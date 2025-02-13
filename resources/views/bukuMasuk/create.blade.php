@extends('layouts.index')
@section('title', 'Tambah Buku Masuk')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Buku Masuk</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('bukuMasuk.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="judul">Judul Buku</label>
                            <select name="buku_id" class="form-control @error('buku_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Judul Buku --</option>
                                @foreach ($buku as $item)
                                    <option value="{{ $item->id }}">{{ $item->judul }}</option>
                                @endforeach
                            </select>
                            @error('buku_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                value="{{ old('jumlah') }}" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-812">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" class="form-control" id="tanggal"
                                    placeholder="Masukkan Tanggal">
                            </div>
                        </div>

                        <!-- Tambahkan form group keterangan -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keterangan">keterangan</label>
                                <textarea name="keterangan" name="keterangan" id="" cols="20" rows="5" class="form-control"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">
                            <i class="fas fa-save"></i> Simpan Buku Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
