<x-layout>
    <x-slot:title>Tambah Produk</x-slot:title>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow">
                <div class="card-header bg-primary text-white py-2">
                    <h6 class="m-0 font-weight-bold">Form Tambah Produk</h6>
                </div>

                <div class="card-body">

                    {{-- ERROR GLOBAL --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/SimpanProduk" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Kode Produk --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Kode Produk</label>
                            <input type="text" name="kode_produk"
                                class="form-control @error('kode_produk') is-invalid @enderror"
                                value="{{ old('kode_produk') }}" placeholder="Contoh: P001">

                            @error('kode_produk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nama Produk --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Nama Produk</label>
                            <input type="text" name="nama_produk"
                                class="form-control @error('nama_produk') is-invalid @enderror"
                                value="{{ old('nama_produk') }}" placeholder="Nama Produk">

                            @error('nama_produk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Harga Beli --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Harga Beli</label>
                            <input type="number" name="harga_beli"
                                class="form-control @error('harga_beli') is-invalid @enderror"
                                value="{{ old('harga_beli') }}" placeholder="Masukkan harga beli">

                            @error('harga_beli')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Harga Jual --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Harga Jual</label>
                            <input type="number" name="harga_jual"
                                class="form-control @error('harga_jual') is-invalid @enderror"
                                value="{{ old('harga_jual') }}" placeholder="Masukkan harga jual">

                            @error('harga_jual')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Stok --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Stok</label>
                            <input type="number" name="stok"
                                class="form-control @error('stok') is-invalid @enderror" 
                                value="{{ old('stok') }}" placeholder="Jumlah stok">

                            @error('stok')
                                <div class="invalid-feedback">  
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Gambar Produk --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Gambar Produk</label>
                            <input type="file" name="gambar_produk" 
                                class="form-control-file @error('gambar_produk') is-invalid @enderror">
                            {{-- ini tambahan sendiri --}}
                            <small class="text-muted">Format: jpg, jpeg, png | Maks: 2MB</small>

                            @error('gambar_produk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        {{-- Tombol --}}
                        <div class="text-center mt-4">

                            <a href="/DataProduk" class="btn btn-outline-secondary px-4 mr-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>

                            <button type="reset" class="btn btn-warning px-4 mr-2">
                                <i class="fas fa-undo"></i> Reset
                            </button>

                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Simpan
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</x-layout>