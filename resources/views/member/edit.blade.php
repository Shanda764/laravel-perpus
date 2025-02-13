@extends('layouts.index')
@section('title', 'Edit Member')

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('member.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="kode_member">Kode Member</label>
                            <input type="text" name="kode_member" id="kode_member" class="form-control"
                                value="{{ $member->kode_member }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ $member->nama }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nis">NIS/NIP</label>
                            <input type="number" name="nis" id="nis" class="form-control"
                                value="{{ $member->nis }}" required>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" id="alamat" class="form-control"
                                value="{{ $member->alamat }}" required>
                        </div>

                        <div class="form-group">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" class="form-control"
                                value="{{ $member->no_telepon }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ $member->email }}">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_daftar">Tanggal Daftar</label>
                            <input type="date" name="tanggal_daftar" id="tanggal_daftar" class="form-control"
                                value="{{ $member->tanggal_daftar }}" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="siswa" {{ $member->status == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="guru" {{ $member->status == 'guru' ? 'selected' : '' }}>Guru</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="gambar">Gambar Member</label>
                            @if ($member->gambar)
                                <br>
                                <img src="{{ asset('storage/' . $member->gambar) }}" alt="Current Image" width="150">
                                <br><br>
                            @endif
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
