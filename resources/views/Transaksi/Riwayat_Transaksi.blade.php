<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('transaksi.index') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Transaksi Baru
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h6 class="m-0 font-weight-bold">Riwayat Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm" style="font-size:13px;" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $index => $trx)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge badge-primary">{{ $trx->kode_transaksi }}</span></td>
                            <td>{{ $trx->user->name ?? '-' }}</td>
                            <td>Rp {{ number_format($trx->total) }}</td>
                            <td>Rp {{ number_format($trx->bayar) }}</td>
                            <td>Rp {{ number_format($trx->kembalian) }}</td>
                            <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('transaksi.detail', $trx->id) }}"
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>