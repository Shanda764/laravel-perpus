@extends('layouts.index')
@section('title', 'Manajemen Laporan Peminjaman dan Pengembalian Buku')
@section('content')
    <div class="container-fluid px-xxl-65 px-xl-20 mt-20">
        <div class="hk-pg-header mb-10">
            <h4 class="hk-pg-title">Laporan Peminjaman dan Pengembalian Buku</h4>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <!-- Form Filter Tanggal -->
                    <form method="GET" action="{{ route('laporan.cari_laporan') }}">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="start_date">Tanggal Mulai:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ request('start_date') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="end_date">Tanggal Selesai:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ request('end_date') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control">Cari</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tombol Cetak PDF -->
                    <form method="GET" action="{{ route('laporan.invoice') }}" target="_blank">
                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                        <button type="submit" class="btn btn-secondary mb-3">Cetak Laporan</button>
                    </form>

                    <hr>
                    <!-- Tabel Laporan -->
                    <div class="table-wrap">
                        <table id="datable_2" class="table table-hover w-100 display">
                            <thead>
                                <tr>
                                    <th>Nama Peminjam</th>
                                    <th>ID Buku</th>
                                    <th>Judul Buku</th>
                                    <th>Status</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayat as $data)
                                    <tr>
                                        <td>{{ $data->nama_peminjam }}</td>
                                        <td>{{ $data->id_buku }}</td>
                                        <td>{{ $data->judul }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $data->status == 'Dikembalikan' ? 'success' : 'warning' }}">
                                                {{ $data->status == 'Dikembalikan' ? 'Dikembalikan' : 'Dipinjam' }}
                                            </span>
                                        </td>
                                        <td>{{ date('d-F-Y', strtotime($data->created_at)) }}</td>
                                        <td>{{ date('d-F-Y', strtotime($data->tanggal_kembali)) }}</td>
                                        <td>Rp.{{ number_format($data->denda) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data untuk rentang tanggal ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection