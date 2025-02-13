<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {

        $pinjam = DB::table('tbl_peminjaman_buku')
            ->join('tbl_member', 'tbl_member.id', '=', 'tbl_peminjaman_buku.id_member') // Gabungkan dengan tabel tbl_member
            ->leftJoin('tbl_riwayat_pinjam', 'tbl_peminjaman_buku.id', '=', 'tbl_riwayat_pinjam.id_peminjaman') // Join dengan riwayat pinjam
            ->leftJoin('tbl_buku', 'tbl_buku.id', '=', 'tbl_riwayat_pinjam.id_buku') // Join dengan tabel buku
            ->select(
                'tbl_peminjaman_buku.id as id_peminjaman', // ID peminjaman
                'tbl_member.nama as nama_member', // Nama member
                'tbl_member.nis as nis_member', // NIS member
                'tbl_member.kode_member as kd_member',
                'tbl_member.gambar',
                'tbl_peminjaman_buku.tanggal_kembali as tanggal_kembali', // Tanggal pengembalian
                'tbl_peminjaman_buku.created_at as created_at_peminjaman', // Tanggal pinjam
                'tbl_buku.judul as judul_buku', // Nama buku
                'tbl_riwayat_pinjam.status as status_riwayat' // Status peminjaman
            )
            ->latest('tbl_peminjaman_buku.created_at') // Urutkan berdasarkan tanggal pinjam
            ->get();
        // Pastikan data ditemukan
        $pinjam = $pinjam->groupBy('id_peminjaman')->map(function ($item) {
            return $item->first(); // Ambil buku pertama dari peminjaman
        });

        return view('pengembalian.index', compact('pinjam'));
    }
    public function scan($id)
    {
        $pengembalian = DB::table('tbl_riwayat_pinjam')
            ->join('tbl_peminjaman_buku', 'tbl_peminjaman_buku.id', '=', 'tbl_riwayat_pinjam.id_peminjaman')
            ->join('tbl_member', 'tbl_member.id', '=', 'tbl_peminjaman_buku.id_member') // Mengambil data member dari peminjaman
            ->join('tbl_buku', 'tbl_buku.id', '=', 'tbl_riwayat_pinjam.id_buku') // Mengambil data buku dari riwayat pinjam
            ->select(
                'tbl_riwayat_pinjam.id as id_riwayat_pinjam',
                'tbl_riwayat_pinjam.denda as denda_riwayat',
                'tbl_riwayat_pinjam.status as status_riwayat',
                'tbl_riwayat_pinjam.tanggal_kembali',
                'tbl_member.nama as nama_member',
                'tbl_member.status as status_member',
                'tbl_buku.judul as judul_buku',
                'tbl_buku.kode as kode_buku',
                'tbl_buku.gambar as gambar_buku'
            )
            ->where('tbl_riwayat_pinjam.id_peminjaman', $id) // Memastikan hanya data peminjaman tertentu yang diambil
            ->latest('tbl_riwayat_pinjam.created_at') // Urutkan berdasarkan tanggal pinjam
            ->get(); // Ambil seluruh data

        // Pastikan data ditemukan
        if ($pengembalian->isEmpty()) {
            return back()->with('fail', 'Tidak ada data peminjaman untuk ditampilkan.');
        }

        return view('pengembalian.detail', compact('pengembalian'));
    }


    public function proses(Request $request)
    {
        $nominal = 1000; // Nominal denda per hari
        $id = $request->id; // ID dari riwayat pinjam

        // Validasi ID riwayat pinjam
        $riwayat = DB::table('tbl_riwayat_pinjam')->where('id', $id)->first();
        if (!$riwayat) {
            return back()->with('fail', 'Data riwayat tidak ditemukan.');
        }

        // Pastikan tanggal kembali dihitung
        $tanggal_kembali = Carbon::parse($riwayat->tanggal_kembali); // Tanggal seharusnya kembali
        $tanggal_sekarang = now();

        // Hitung jumlah hari keterlambatan
        $hari_terlambat = $tanggal_sekarang->greaterThan($tanggal_kembali)
            ? $tanggal_sekarang->diffInDays($tanggal_kembali)
            : 0;

        // Hitung denda
        $denda = $hari_terlambat * $nominal;

        // Update stok buku
        $id_buku = $riwayat->id_buku;
        DB::table('tbl_buku')->where('id', $id_buku)->increment('stok');

        // Update status dan denda di tbl_riwayat_pinjam
        DB::table('tbl_riwayat_pinjam')->where('id', $id)->update([
            'denda' => $denda,
            'status' => 'Dikembalikan', // Mengubah status
        ]);

        return back()->with('success', 'Berhasil Melakukan Proses Pengembalian Buku.');
    }
    
}
