@extends('layouts.index')
@section('title', 'Manajemen Buku')
@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable @yield('title')</h3>
                    <a href="{{ route('daftar_buku.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i>
                        Tambah</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px">No</th>
                                <th>Kode Buku</th>
                                <th>Judul Buku</th>
                                <th>Kategori Buku</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Stok</th>
                                <th>Lokasi</th>
                                <th>Gambar</th>
                                <th width="10px">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($buku as $b)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $b->kode }}</td>
                                    <td>{{ $b->judul }}</td>
                                    <td>{{ $b->namaKategori }}</td>
                                    <td>{{ $b->pengarang }}</td>
                                    <td>{{ $b->penerbit }}</td>
                                    <td>{{ $b->tahun_terbit }}</td>
                                    <td>{{ $b->stok }}</td>
                                    <td>{{ $b->lokasi }}</td>
                                    <td>
                                        @if ($b->gambar)
                                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="Gambar Buku"
                                                width="50">
                                        @else
                                            <span class="text-muted">Tidak Ada Gambar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('daftar_buku.edit', $b->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('daftar_buku.destroy', $b->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th width="10px">No</th>
                                <th>Kode Buku</th>
                                <th>Judul Buku</th>
                                <th>Kategori Buku</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Stok</th>
                                <th>Lokasi</th>
                                <th>Gambar</th>
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
