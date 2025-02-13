@extends('layouts.index')
@section('title', 'Manajemen Buku Masuk')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable @yield('title')</h3>
                    <a href="{{ route('bukuMasuk.create') }}" class="btn btn-primary float-right">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px">No</th>
                                <th>Judul Buku</th>
                                <th>Jumlah</th>
                                <th>Tanggal Masuk</th>
                                <th>Keterangan</th>
                                <th width="10px">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($bukuMasuk as $bm)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bm->judul }}</td>
                                    <td>{{ $bm->jumlah }}</td>
                                    <td>{{ $bm->tanggal_masuk }}</td>
                                    <td>{{ $bm->keterangan }}</td>
                                    <td>
                                        <a href="{{ route('bukuMasuk.edit', $bm->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('bukuMasuk.destroy', $bm->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Jumlah</th>
                                <th>Tanggal Masuk</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
