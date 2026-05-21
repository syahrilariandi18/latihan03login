<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class TransaksiController extends Controller
{
    /**
     * TAMPILAN FORM TRANSAKSI + KERANJANG
     */
    public function index()
    {
        // Hanya mengambil produk yang stoknya masih ada
        $produk = Produk::where('stok', '>', 0)->get();
        $keranjang = session('keranjang', []);
        $total = collect($keranjang)->sum('subtotal');

        return view('Transaksi.Form_Transaksi', [
            'title'     => 'Form Transaksi',
            'produk'    => $produk,
            'keranjang' => $keranjang,
            'total'     => $total,
        ]);
    }

    /**
     * TAMBAH PRODUK KE KERANJANG (SESSION)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'qty'       => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $keranjang = session('keranjang', []);

        // Jika produk sudah ada di keranjang, akumulasikan qty-nya
        if (isset($keranjang[$produk->id])) {
            $newQty = $keranjang[$produk->id]['qty'] + $request->qty;

            // Validasi agar total qty di keranjang tidak melebihi stok di gudang
            if ($newQty > $produk->stok) {
                return back()->with('error', 'Total qty melebihi stok! Stok tersedia: ' . $produk->stok);
            }

            $keranjang[$produk->id]['qty']      = $newQty;
            $keranjang[$produk->id]['subtotal']  = $newQty * $produk->harga_jual;
        } else {
            // Jika produk baru pertama kali dimasukkan ke keranjang
            if ($request->qty > $produk->stok) {
                return back()->with('error', 'Stok produk tidak mencukupi! Stok tersedia: ' . $produk->stok);
            }

            $keranjang[$produk->id] = [
                'produk_id'   => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'harga'       => $produk->harga_jual,
                'qty'         => $request->qty,
                'subtotal'    => $request->qty * $produk->harga_jual,
            ];
        }

        session(['keranjang' => $keranjang]);
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * HAPUS ITEM DARI KERANJANG
     */
    public function removeFromCart($produk_id)
    {
        $keranjang = session('keranjang', []);

        if (isset($keranjang[$produk_id])) {
            unset($keranjang[$produk_id]);
            session(['keranjang' => $keranjang]);
        }

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    /**
     * PROSES CHECKOUT (DATABASE TRANSACTION + ATOMIC DECREMENT)
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'bayar' => 'required|integer|min:0',
        ]);

        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $total = collect($keranjang)->sum('subtotal');

        if ($request->bayar < $total) {
            return back()->with('error', 'Uang bayar kurang! Total: Rp ' . number_format($total));
        }

        $kembalian = $request->bayar - $total;
        
        // Membuat kode transaksi unik bertipe bahasa Indonesia
        $kode = 'TRX-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

        // Memulai DB Transaction dengan Try Catch agar penanganan error lebih aman
        DB::beginTransaction();

        try {
            // 1. Simpan data transaksi utama (Header)
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kode,
                'user_id'        => Auth::id(),
                'total'          => $total,
                'bayar'          => $request->bayar,
                'kembalian'      => $kembalian,
            ]);

            // 2. Loop keranjang untuk simpan rincian detail & kurangi stok
            foreach ($keranjang as $item) {
                $produk = Produk::findOrFail($item['produk_id']);

                // Proteksi ganda: Cek ulang stok tepat di detik kasir menekan tombol bayar
                if ($item['qty'] > $produk->stok) {
                    throw new \Exception('Stok produk "' . $produk->nama_produk . '" mendadak tidak mencukupi!');
                }

                // Simpan data ke tabel detail_transaksi
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $item['produk_id'],
                    'harga'        => $item['harga'],
                    'qty'          => $item['qty'],
                    'subtotal'     => $item['subtotal'],
                ]);

                // Kurangi stok menggunakan metode decrement (Aman dari Race Condition)
                $produk->decrement('stok', $item['qty']);
            }

            // Jika semua proses sukses, kosongkan keranjang dan kunci data ke database
            session()->forget('keranjang');
            DB::commit();

            return redirect()->route('transaksi.detail', $transaksi->id)
                ->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            // Jika ada satu saja yang gagal/stok kurang, batalkan semua perubahan database
            DB::rollBack();
            return back()->with('error', 'Transaksi gagal: ' . $e->getMessage());
        }
    }

    /**
     * RIWAYAT TRANSAKSI (ROLE BASED + PAGINATION)
     */
    public function riwayat()
    {
        $user = Auth::user();

        // Menggabungkan logika hak akses dengan Pagination (Membatasi 10 data per halaman agar aplikasi ringan)
        if ($user->role === 'kasir') {
            $transaksi = Transaksi::with('user')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            $transaksi = Transaksi::with('user')
                ->latest()
                ->paginate(10);
        }

        return view('Transaksi.Riwayat_Transaksi', [
            'title'     => 'Riwayat Transaksi',
            'transaksi' => $transaksi,
        ]);
    }

    /**
     * DETAIL TRANSAKSI (EAGER LOADING SINGULAR)
     */
    public function detail($id)
    {
        // Menggunakan 'detail.produk' (tanpa s) sesuai nama relasi tunggal di Model Transaksi
        $transaksi = Transaksi::with(['detail.produk', 'user'])->findOrFail($id);

        return view('Transaksi.Detail_Transaksi', [
            'title'     => 'Detail Transaksi',
            'transaksi' => $transaksi,
        ]);
    }
}