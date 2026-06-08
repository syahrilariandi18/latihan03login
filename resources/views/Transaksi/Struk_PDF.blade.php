<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Font khas struk kasir */
            font-size: 10px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        .header { margin-bottom: 8px; }
        .header .nama-toko { font-size: 12px; font-weight: bold; }
        .tabel-barang {
            width: 100%;
            border-collapse: collapse;
        }
        .tabel-barang td { padding: 2px 0; vertical-align: top; }
        .tabel-total {
            width: 100%;
            margin-top: 5px;
        }
        .tabel-total td { padding: 1px 0; }
        .footer {
            margin-top: 15px;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <div class="header text-center">
        <span class="nama-toko">MINI POS TOKO RIL</span><br>
        <span>Jl. Raya Bogor No. 18, Jawa Barat, Indonesia</span><br>
        <div class="divider"></div>
        <table style="width:100%; font-size:9px;">
            <tr>
                <td>No  : {{ $transaksi->kode_transaksi }}</td>
                <td class="text-right">Kasir: {{ $transaksi->user->name ?? 'Kasir' }}</td>
            </tr>
            <tr>
                <td colspan="2">Tgl : {{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <div class="divider"></div>

    <table class="tabel-barang">
        @foreach($transaksi->rincian as $item)
            <tr>
                <td colspan="3">{{ $item->produk->nama_produk }}</td>
            </tr>
            <tr>
                <td style="width: 40%;">{{ $item->qty }} x {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td style="width: 10%;"></td>
                <td class="text-right" style="width: 50%;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <table class="tabel-total">
        <tr>
            <td>TOTAL</td>
            <td class="text-right">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>BAYAR</td>
            <td class="text-right">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
        </tr>
        <tr style="font-weight: bold;">
            <td>KEMBALIAN</td>
            <td class="text-right">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="footer text-center">
        <span>* TERIMA KASIH *</span><br>
        <span>Sudah belanja di toko kami.</span><br>
        <span>Selamat berbelanja kembali!</span>
    </div>

</body>
</html>