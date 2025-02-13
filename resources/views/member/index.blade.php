@extends('layouts.index')
@section('title', 'Manajemen Member')
@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable @yield('title')</h3>
                    <a href="{{ route('member.create') }}" class="btn btn-primary float-right"><i ></i>
                        Tambah Member</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px">No</th>
                                <th>Kode Member</th>
                                <th>Nama</th>
                                <th>Nis/Nip</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                                <th>Email</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Foto</th>
                                <th width="10px">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->kode_member }}</td>
                                    <td>{{ $member->nama }}</td>
                                    <td>{{ $member->nis }}</td>
                                    <td>{{ $member->alamat }}</td>
                                    <td>{{ $member->no_telepon }}</td>
                                    <td>{{ $member->email ?? 'Tidak Ada' }}</td>
                                    <td>{{ $member->tanggal_daftar }}</td>
                                    <td>{{ $member->status }}</td>
                                    <td>
                                        @if ($member->gambar)
                                            <img src="{{ asset('storage/' . $member->gambar) }}" alt="Gambar Member"
                                                width="50">
                                        @else
                                            <span class="text-muted">Tidak Ada Gambar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('member.edit', $member->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('member.destroy', $member->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus member ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('member.show', $member->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th width="10px">No</th>
                                <th>Kode Member</th>
                                <th>Nama</th>
                                <th>Nis/Nip</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                                <th>Email</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Foto</th>
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
