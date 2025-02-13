@extends('layouts.index')
@section('title', 'Manajemen Cetak Kartu Member')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DataTable @yield('title')</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="container" id="printableArea">
                    <!-- Header -->
                    <div class="card-header">
                        <h3>Kartu Anggota Perpustakaan SDN 019 AURSATI</h3>
                        <p>Desa Aursati, Kecamatan Tambang, Kabupaten Kampar, Riau</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <div class="info-container">
                            <div class="member-image">
                                @if ($member->gambar)
                                    <img src="{{ asset('storage/' . $member->gambar) }}" alt="Foto Member" height="150"
                                        width="90" class="img-thumbnail">
                                @else
                                    <img src="{{ asset('storage/Foto/default.jpg') }}" alt="Foto Default" height="100"
                                        width="100" class="img-thumbnail">
                                @endif
                            </div>
                            <div class="member-details">
                                <h2 class="text-center">Informasi Anggota</h2>
                                <!-- Tabel untuk Menampilkan Informasi Anggota -->
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Kode Member</th>
                                        <td>{{ $member->kode_member }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>{{ $member->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIS/NIP</th>
                                        <td>{{ $member->nis }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $member->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th>No Telepon</th>
                                        <td>{{ $member->no_telepon }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Daftar</th>
                                        <td>{{ \Carbon\Carbon::parse($member->tanggal_daftar)->format('d-m-Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="text-center">
                <!-- Tombol Cetak -->
                <button onclick="printDiv('printableArea')" class="btn btn-success">Cetak Kartu Member</button>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

<!-- JavaScript untuk Mencetak -->
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f6f9;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        border: 1px solid #ddd;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #28a745;
        color: white;
        padding: 10px;
        text-align: center;
        border-radius: 8px 8px 0 0;
    }

    .card-body {
        padding: 20px;
    }

    .card-body p {
        font-size: 14px;
        margin: 5px 0;
    }

    .text-center {
        text-align: center;
    }

    .info-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .member-image {
        margin-right: 20px;
    }

    .member-image img {
        border-radius: 8px;
    }

    .member-details {
        flex: 1;
    }

    /* Styling untuk tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    /* Styling untuk tombol */
    .btn {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }

    /* Media Query untuk Pencetakan */
    @media print {
        body {
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .container {
            width: 100%;
            padding: 10px;
            box-shadow: none;
            border-radius: 0;
        }

        .card-header,
        .card-body {
            padding: 10px;
        }

        .member-image img {
            width: 100px;
            height: 150px;
        }

        .info-container {
            display: block;
            margin-bottom: 20px;
        }

        .member-details table {
            width: 100%;
            margin-top: 10px;
        }

        .text-center {
            text-align: center;
        }

        .btn {
            display: none;
        }
    }
</style>
@endsection