@extends('layouts.index')
@section('title', 'Edit Buku Masuk')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Buku Masuk</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('bukuMasuk.update', $buku_masuk->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="judul">Judul Buku</label>
                            <select name="buku_id" class="form-control @error('buku_id') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih Judul Buku --</option>
                                @foreach ($buku as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $buku_masuk->buku_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->judul }}
                                    </option>
                                @endforeach
                            </select>
                            @error('buku_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                value="{{ old('jumlah', $buku_masuk->jumlah) }}" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                value="{{ old('tanggal_masuk', $buku_masuk->tanggal_masuk) }}" required>
                            @error('tanggal_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tambahkan form group keterangan -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keterangan">keterangan</label>
                                <textarea name="keterangan" name="keterangan" id="" cols="20" rows="5" class="form-control">{{ $buku_masuk->keterangan }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">
                            <i class="fas fa-save"></i> Perbarui Buku Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
