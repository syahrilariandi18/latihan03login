<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Tombol Tambah -->
    <div class="mb-3">
        <a href="/TambahProduk" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    <!-- Tabel -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm" style="font-size:14px;">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_produk as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kode_produk }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>Rp {{ number_format($item->harga_jual) }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>
                                    <!-- Detail -->
                                    <a href="/DetailProduk/{{ $item->id }}" class="btn btn-info btn-sm"
                                    title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="/EditProduk/{{ $item->id }}" class="btn btn-warning btn-sm"
                                    title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Hapus -->
                                    <a href="/HapusProduk/{{ $item->id }}" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus data?')">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layout>
