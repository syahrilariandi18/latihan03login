<x-layout>
    <x-slot:title>Edit Produk</x-slot:title>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">Form Edit Produk</h6>
                </div>

                <div class="card-body">

                    <form action="/UpdateProduk/{{ $produk->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label>Kode Produk</label>
                            <input type="text" name="kode_produk" class="form-control"
                                value="{{ old('kode_produk', $produk->kode_produk) }}">
                        </div>

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control"
                                value="{{ old('nama_produk', $produk->nama_produk) }}">
                        </div>

                        <div class="form-group">
                            <label>Harga Beli</label>
                            <input type="number" name="harga_beli" class="form-control"
                                value="{{ old('harga_beli', $produk->harga_beli) }}">
                        </div>

                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control"
                                value="{{ old('harga_jual', $produk->harga_jual) }}">
                        </div>

                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stok" class="form-control"
                                value="{{ old('stok', $produk->stok) }}">
                        </div>

                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" name="gambar" class="form-control-file">

                            <div class="mt-2">
                                @if ($produk->gambar && file_exists(public_path('gambar_produk/' . $produk->gambar)))
                                    <img src="{{ asset('gambar_produk/' . $produk->gambar) }}" class="img-thumbnail"
                                        width="120">
                                @else
                                    <img src="{{ asset('img/no-image.jpg') }}" class="img-thumbnail" width="120">
                                    <div class="text-muted small">No Image</div>
                                @endif
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="/DataProduk" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-layout>