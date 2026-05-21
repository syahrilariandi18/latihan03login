<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Info Transaksi --}}
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-receipt"></i> Detail Transaksi
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="150">Kode Transaksi</th>
                            <td>: <span class="badge badge-primary">{{ $transaksi->kode_transaksi }}</span></td>
                        </tr>
                        <tr>
                            <th>Kasir</th>
                            <td>: {{ $transaksi->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>: {{ $transaksi->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>: <strong>Rp {{ number_format($transaksi->total) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Bayar</th>
                            <td>: Rp {{ number_format($transaksi->bayar) }}</td>
                        </tr>
                        <tr>
                            <th>Kembalian</th>
                            <td>: <span class="text-success font-weight-bold">Rp {{ number_format($transaksi->kembalian) }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Detail Barang --}}
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">Detail Barang yang Dibeli</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Harga Saat Beli</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi->detail as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->produk->nama_produk ?? '[Produk Dihapus]' }}</td>
                                    <td>Rp {{ number_format($item->harga) }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp {{ number_format($item->subtotal) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">TOTAL</th>
                                    <th>Rp {{ number_format($transaksi->total) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <a href="{{ route('transaksi.riwayat') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
            </a>
            <a href="{{ route('transaksi.index') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Transaksi Baru
            </a>

        </div>
    </div>
</x-layout>