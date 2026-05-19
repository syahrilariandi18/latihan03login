<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Detail Produk</h6>
                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- Detail (KIRI) --}}
                        <div class="col-md-8">
                            <table class="table table-sm">
                                <tr>
                                    <th width="150">Kode Produk</th>
                                    <td>: {{ $produk->kode_produk }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Produk</th>
                                    <td>: {{ $produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Beli</th>
                                    <td>: Rp {{ number_format($produk->harga_beli) }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Jual</th>
                                    <td>: Rp {{ number_format($produk->harga_jual) }}</td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td>: {{ $produk->stok }}</td>
                                </tr>
                            </table>
                        </div>

                        {{-- Gambar (KANAN) --}}
                        <div class="col-md-4 text-center">
                            @if ($produk->gambar && file_exists(public_path('gambar_produk/' . $produk->gambar)))
                                <img src="{{ asset('gambar_produk/' . $produk->gambar) }}"
                                    class="img-fluid rounded shadow-sm mb-2" style="max-height:200px;">
                            @else
                                <img src="{{ asset('img/no-image.jpg') }}" class="img-fluid rounded shadow-sm mb-2"
                                    style="max-height:200px;">
                                <p class="text-muted small">No Image</p>
                            @endif
                        </div>

                    </div>

                    {{-- Tombol --}}
                    <div class="text-center mt-4">

                        <a href="/DataProduk" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                        <a href="/EditProduk/{{ $produk->id }}" class="btn btn-warning mr-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <a href="/HapusProduk/{{ $produk->id }}" class="btn btn-danger"
                            onclick="return confirm('Yakin hapus data?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layout>