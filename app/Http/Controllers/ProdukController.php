<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $data_produk = Produk::all();

        return view('Produk.Data_Produk', [
            'title' => 'Data Produk',
            'data_produk' => $data_produk
        ]);
    }

    public function tambah()
    {
        return view('Produk.Tambah_Produk', [
            'title' => 'Tambah Produk'
        ]);
    }

    public function simpan(Request $request)
    {
        // VALIDASI
        $request->validate([
            'kode_produk' => 'required|unique:produk,kode_produk|max:20',
            'nama_produk' => 'required|max:100',
            'harga_beli'  => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload gambar (jika ada)
        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('gambar_produk'), $nama_file);
        } else {
            $nama_file = null;
        }
        
        // Simpan ke database
        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga_beli'  => $request->harga_beli,
            'harga_jual'  => $request->harga_jual,
            'stok'        => $request->stok,
            'gambar'      => $nama_file
        ]);

        return redirect('/DataProduk')->with('success', 'Data berhasil ditambahkan');
        }

    public function detail($id)
    {
        $produk = Produk::findOrFail($id);

        return view('Produk.Detail_Produk', [
            'title' => 'Detail Produk',
            'produk' => $produk
        ]);
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        return view('Produk.Edit_Produk', [
            'title' => 'Edit Produk',
            'produk' => $produk
        ]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'kode_produk' => 'required|max:20|unique:produk,kode_produk,' . $id,
            'nama_produk' => 'required|max:100',
            'harga_beli'  => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:5048'
        ]);

        $nama_file = $produk->gambar; // Default lama

        // Kalau upload gambar baru
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($produk->gambar) {
                unlink(public_path('gambar_produk/' . $produk->gambar));
            }

            // Upload gambar baru
            $file = $request->file('gambar');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('gambar_produk'), $nama_file);
        } else {
            $nama_file = $produk->gambar; // Tetap gunakan gambar lama jika tidak diubah
        }
        
        // Update data di database
        $produk->update([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga_beli'  => $request->harga_beli,
            'harga_jual'  => $request->harga_jual,
            'stok'        => $request->stok,
            'gambar'      => $nama_file
        ]);

        return redirect('/DataProduk')->with('success', 'Data berhasil diperbarui');
    }

    public function hapus($id)
    {
        // Ambil data produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // Hapus gambar jika ada
        if ($produk->gambar) {
            unlink(public_path('gambar_produk/' . $produk->gambar));
        }

        // Hapus data produk dari database
        $produk->delete();

        return redirect('/DataProduk')->with('success', 'Data berhasil dihapus');
    }
}
