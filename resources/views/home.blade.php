<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }
</style>
@extends('layouts.index')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ count($kategoriBuku) }}</h3>
                <p>Total Kategori Buku</p>
            </div>
            <div class="icon">
                <i class="fa fa-book"></i>
            </div>
            <a href="{{ route('kategori') }}" class="small-box-footer">Lihat <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ count($daftarBuku) }}</h3>
                <p>Total Daftar Buku</p>
            </div>
            <div class="icon">
                <i class="fa fa-book-open"></i>
            </div>
            <a href="{{ route('daftar_buku') }}" class="small-box-footer">Lihat <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ count($daftarMember) }}</h3>
                <p>Total Daftar Member</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{ route('member') }}" class="small-box-footer">Lihat <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ count($bukuMasuk) }}</h3>
                <p>Total Buku Masuk</p>
            </div>
            <div class="icon">
                <i class="fa fa-book-reader"></i>
            </div>
            <a href="{{ route('bukuMasuk') }}" class="small-box-footer">Lihat <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@endsection
