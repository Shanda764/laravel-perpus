@extends('layouts.index')

@section('title', 'Manajemen Pinjam Buku')

@section('content')
    <div class="container-fluid px-xxl-65 px-xl-20 mt-20">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading mb-10">Catatan Peminjaman Buku</h4>
                    <p>Beberapa peraturan dalam peminjaman buku di perpustakaan</p>
                    <hr class="hr-soft-info">
                    @php
                        $cek_denda = DB::table('tbl_denda')->first();
                        $tarif_denda = $cek_denda ? $cek_denda->nominal_denda : 1000;
                    @endphp
                    <ul class="list-ul">
                        <li>Anggota diwajibkan mendaftarkan diri untuk melakukan peminjaman buku.</li>
                        <li>Waktu peminjaman buku hanya 7 hari. Apabila melewati waktu pengembalian, akan dikenakan denda.
                        </li>
                        <li>Tarif Denda: Rp. {{number_format($tarif_denda, 0, ',', '.')}} / Hari</li>
                        <li>Jika buku hilang, maka siswa dikenakan denda sebesar Rp. 100.000 / buku.</li>
                    </ul>
                </div>
            </div>
        </div>

        @if   (session('fail'))
            <div class="alert alert-danger alert-wth-icon fade show" role="alert">
                <span class="alert-icon-wrap"><i class="zmdi zmdi-block"></i></span>
                {{session('fail')}}
            </div>
        @endif



        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <!-- Info Member -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{asset('storage/' . $member->gambar)}}" height="100" width="100"
                                            alt="Member Image" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="col-8">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td><b>Nama</b></td>
                                                    <td>: {{strtoupper($member->nama)}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>NIS/NIP</b></td>
                                                    <td>: {{strtoupper($member->nis)}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Status</b></td>
                                                    <td>: {{strtoupper($member->status)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Info Member -->

                    <!-- Form Peminjaman -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <p>Pemilihan Buku Untuk Dipinjam <span style="color:red">* Maksimal 2 Buku</span></p>
                            </div>
                            <div class="card-body">
                                <form action="{{route('peminjaman.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id_member" value="{{$member->id}}">

                                    <!-- Buku Pertama -->
                                    <!-- Buku Pertama (Wajib) -->
                                    <!-- Buku Pertama (Wajib) -->
                                    <div class="form-group">
                                        <label for="buku1" class="mt-10">Buku 1</label>
                                        <select class="form-control @error('id_buku.0') is-invalid @enderror"
                                            name="id_buku[0]" required>
                                            <option value="">Pilih Buku</option>
                                            @foreach  ($buku as $data)
                                                <option value="{{$data->id}}" {{old('id_buku.0') == $data->id ? 'selected' : ''}}>
                                                    [{{$data->judul}}] - {{$data->judul}}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('id_buku.0')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <!-- Buku Kedua (Opsional) -->
                                    <div class="form-group">
                                        <label for="buku2" class="mt-10">Buku 2</label>
                                        <select class="form-control @error('id_buku.1') is-invalid @enderror"
                                            name="id_buku[1]">
                                            <option value="">Pilih Buku</option>
                                            @foreach  ($buku as $data)
                                                <option value="{{$data->id}}" {{old('id_buku.1') == $data->id ? 'selected' : ''}}>
                                                    [{{$data->judul}}] - {{$data->judul}}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('id_buku.1')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <button class="btn btn-success w-100 mt-10" type="submit">Proses Peminjaman
                                        Buku</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Form Peminjaman -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .card {
            margin-bottom: 20px;
        }

        .table td,
        .table th {
            padding: 8px;
            vertical-align: middle;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .invalid-feedback {
            display: block;
        }
    </style>
@endsection

@section('js')
    <!-- Tidak menggunakan JavaScript lagi, karena sudah tidak diperlukan -->
@endsection