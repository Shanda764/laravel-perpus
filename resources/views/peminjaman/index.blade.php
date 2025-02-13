@extends('layouts.index')

@section('title', 'Peminjaman Buku')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-light">
            <div class="card-header bg-primary text-white text-center">
                <h1 class="mb-0">Masukkan NIS Untuk Peminjaman Buku</h1>
            </div>
            <div class="card-body d-flex flex-column">
                <form action="{{ route('peminjaman.cek') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="nis" class="font-weight-bold">Masukkan NIS</label>
                        <input type="text" name="nis" id="nis" class="form-control"
                            placeholder="Masukkan NIS Siswa" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Cek Member</button>
                    </div>
                </form>

                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                @endif

                @if (session('fail'))
                    <div class="alert alert-danger mt-3">
                        <strong>Gagal!</strong> {{ session('fail') }}
                    </div>
                @endif

                {{-- Display the latest borrowing record --}}
                @if ($latestPeminjaman)
                    @if ($latestPeminjaman->tanggal_kembali === null)
                        <div class="alert alert-warning mt-4">
                            <strong>Peringatan!</strong> Anda masih memiliki pinjaman aktif.
                        </div>
                    @else
                        <div class="alert alert-info mt-4">
                            <strong>Baru Saja Dipinjam:</strong> <br>
                            Nama Member: {{ $latestPeminjaman->nama_member }} <br>
                            Judul Buku: {{ $latestPeminjaman->judul_buku }} <br>
                            Tanggal Pinjam: {{ \Carbon\Carbon::parse($latestPeminjaman->created_at)->format('d-m-Y') }} <br>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
