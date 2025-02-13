<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $kategoriBuku = DB::table('tbl_kategori')->get();
        $daftarBuku = DB::table('tbl_buku')->get();
        $daftarMember = DB::table('tbl_member')->get();
        $bukuMasuk = DB::table('tbl_masuk_buku')->get();

        return view('home', compact('kategoriBuku', 'daftarBuku', 'daftarMember', 'bukuMasuk'));
    }
}
