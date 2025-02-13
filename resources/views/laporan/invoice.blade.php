<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Dan Pengembalian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Transaksi Peminjaman</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Status</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayat as $key => $data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->nama_peminjam }}</td>
                    <td>{{ $data->judul }}</td>
                    <td>{{ $data->status }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal_kembali)->format('d F Y') }}</td>
                    <td>{{ 'Rp. ' . number_format($data->denda) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
