@extends('layouts.index')

@section('title', 'Daftar Peminjaman Buku')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DataTable @yield('title')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Kode Member</th>
                            <th>Foto Member</th>
                            <th>Nama Member</th>
                            <th>NIS/NIP</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th width="10px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach   ($pinjam as $pengembalian)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$pengembalian->kd_member}}</td>
                                <td>
                                    @if  ($pengembalian->gambar)
                                        <img src="{{asset('storage/' . $pengembalian->gambar)}}" alt="Gambar Member" width="50">
                                    @else

                                        <span class="text-muted">Tidak Ada Gambar</span>
                                    @endif

                                </td>
                                <td>{{$pengembalian->nama_member}}</td>
                                <td>{{$pengembalian->nis_member}}</td>
                                <td>{{$pengembalian->judul_buku}}</td>
                                <td>{{\Carbon\Carbon::parse($pengembalian->created_at_peminjaman)->format('d-m-Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d-m-Y')}}</td>
                                <td>{{ucfirst($pengembalian->status_riwayat)}}</td>
                                <td>
                                    <a href="{{route('pengembalian.detail', $pengembalian->id_peminjaman)}}"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>

                    <tfoot>
                        <tr>
                            <th width="10px">No</th>
                            <th>Kode Member</th>
                            <th>Foto Member</th>
                            <th>Nama Member</th>
                            <th>NIS/NIP</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th width="10px">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection
