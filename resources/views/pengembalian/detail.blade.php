@extends('layouts.index')

@section('title', 'Manajemen Pengembalian Buku')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data @yield('title')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Nama Member</th>
                            <th>Judul Buku</th>
                            <th>Kode Buku</th> <!-- Tambahan kolom kode buku -->
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th>Gambar Buku</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach  ($pengembalian as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama_member}}</td> <!-- Nama Member -->
                                <td>{{$item->judul_buku}}</td> <!-- Judul Buku -->
                                <td>{{$item->kode_buku}}</td> <!-- Kode Buku -->
                                <td>
                                    @if   ($item->tanggal_kembali)
                                        {{\Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y')}}
                                    @else


                                        <span class="text-muted">Belum Dikembalikan</span>
                                    @endif


                                </td>
                                <td>{{ucfirst($item->status_riwayat)}}</td> <!-- Status Member -->
                                <td>
                                    @if   ($item->denda_riwayat > 0)
                                        Rp. {{number_format($item->denda_riwayat, 0, ',', '.')}}
                                    @else


                                        Tidak Ada Denda
                                    @endif


                                </td>
                                <td>
                                    @if   ($item->gambar_buku)
                                        <img src="{{asset('storage/' . $item->gambar_buku)}}" alt="Gambar Buku" width="50">
                                    @else


                                        <span class="text-muted">Tidak Ada Gambar</span>
                                    @endif


                                </td>
                                <td>
                                    @if   ($item->status_riwayat == 'selesai') <!-- Status Riwayat -->
                                        <a href="{{route('pengembalian.detail', $item->id_riwayat_pinjam)}}"
                                            class="btn btn-sm btn-info" title="Detail Pengembalian">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    @else


                                        <form method="POST" action="{{route('pengembalian.proses')}}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$item->id_riwayat_pinjam}}">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check-circle"></i> Proses Pengembalian
                                            </button>
                                        </form>
                                    @endif


                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                    <tfoot>
                        <tr>
                            <th width="10px">No</th>
                            <th>Nama Member</th>
                            <th>Judul Buku</th>
                            <th>Kode Buku</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th>Gambar Buku</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer d-flex justify-content-end">
                <a href="{{route('pengembalian.index')}}" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i> Selesai
                </a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection
