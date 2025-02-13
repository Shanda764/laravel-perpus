@extends('layouts.index')
@section('title', 'Edit Buku')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Buku</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Tampilkan error jika ada -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Edit Buku -->
                    <form action="{{ route('daftar_buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Input Kode Buku -->
                        <div class="form-group">
                            <label for="kode">Kode Buku</label>
                            <input type="text" name="kode" class="form-control" value="{{ $buku->kode }}" readonly>
                        </div>

                        <!-- Input Judul Buku -->
                        <div class="form-group">
                            <label for="judul">Judul Buku</label>
                            <input type="text" name="judul" class="form-control" value="{{ $buku->judul }}" required>
                        </div>

                        <!-- Dropdown Kategori -->
                        <div class="form-group">
                            <label for="kategori">Kategori Buku</label>
                            <select name="kategori_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $buku->kategori_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Pengarang Buku -->
                        <div class="form-group">
                            <label for="pengarang">Pengarang</label>
                            <input type="text" name="pengarang" class="form-control" value="{{ $buku->pengarang }}"
                                required>
                        </div>

                        <!-- Input Penerbit Buku -->
                        <div class="form-group">
                            <label for="penerbit">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" value="{{ $buku->penerbit }}"
                                required>
                        </div>

                        <!-- Input Tahun Terbit Buku -->
                        <div class="form-group">
                            <label for="tahun_terbit">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control" value="{{ $buku->tahun_terbit }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="stok">stok</label>
                            <input type="text" name="stok" class="form-control" value="{{ $buku->stok }}" required>
                        </div>

                        <!-- Input Lokasi Buku -->
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="{{ $buku->lokasi }}" required>
                        </div>

                        <!-- Gambar Buku -->
                        <div class="form-group">
                            <label for="gambar">Gambar Saat Ini</label><br>
                            @if ($buku->gambar)
                                <img src="{{ asset('storage/' . $buku->gambar) }}" alt="Gambar Buku" width="80"
                                    height="100">
                            @else
                                <span class="text-muted">Tidak Ada Gambar</span>
                            @endif
                        </div>

                        <!-- Upload Gambar Baru -->
                        <div class="form-group">
                            <label for="gambar">Upload Gambar Baru</label>
                            <input type="file" name="gambar" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-success mt-3">
                            <i class="fas fa-save"></i> Perbarui
                        </button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
