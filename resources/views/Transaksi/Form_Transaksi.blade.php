<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">

        {{-- KIRI: Form Pilih Produk --}}
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Pilih Produk</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.addToCart') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Produk</label>
                            <select name="produk_id" class="form-control" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produk as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->nama_produk }} | Stok: {{ $p->stok }} | Rp {{ number_format($p->harga_jual) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jumlah (Qty)</label>
                            <input type="number" name="qty" class="form-control" min="1" value="1" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-plus"></i> Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- KANAN: Keranjang Belanja --}}
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-shopping-cart"></i> Keranjang Belanja
                    </h6>
                </div>
                <div class="card-body">

                    @if(empty($keranjang))
                        <p class="text-muted text-center">Keranjang masih kosong.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" style="font-size:13px;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($keranjang as $item)
                                    <tr>
                                        <td>{{ $item['nama_produk'] }}</td>
                                        <td>Rp {{ number_format($item['harga']) }}</td>
                                        <td>{{ $item['qty'] }}</td>
                                        <td>Rp {{ number_format($item['subtotal']) }}</td>
                                        <td>
                                            <a href="{{ route('transaksi.removeFromCart', $item['produk_id']) }}"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Hapus item ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">TOTAL</th>
                                        <th colspan="2">Rp {{ number_format($total) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Form Checkout --}}
                        <form action="{{ route('transaksi.checkout') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">Uang Bayar (Rp)</label>
                                <input type="number" name="bayar" class="form-control form-control-lg"
                                       min="{{ $total }}" placeholder="Masukkan uang bayar" required>
                            </div>
                            <div class="form-group">
                                <label>Total Belanja</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($total) }}" readonly>
                            </div>
                            <button type="submit" class="btn btn-success btn-block btn-lg">
                                <i class="fas fa-check-circle"></i> PROSES CHECKOUT
                            </button>
                        </form>
                    @endif

                </div>
            </div>

            {{-- Link ke Riwayat --}}
            <a href="{{ route('transaksi.riwayat') }}" class="btn btn-info btn-block">
                <i class="fas fa-history"></i> Lihat Riwayat Transaksi
            </a>
        </div>

    </div>
</x-layout>