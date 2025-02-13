<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Menampilkan halaman laporan
    public function index()
    {
        $riwayat = DB::table('tbl_riwayat_pinjam')
            ->join('tbl_buku', 'tbl_riwayat_pinjam.id_buku', '=', 'tbl_buku.id')
            ->join('tbl_peminjaman_buku', 'tbl_riwayat_pinjam.id_peminjaman', '=', 'tbl_peminjaman_buku.id')
            ->join('tbl_member', 'tbl_peminjaman_buku.id_member', '=', 'tbl_member.id')
            ->select(
                'tbl_riwayat_pinjam.*',
                'tbl_buku.judul',
                'tbl_member.nama as nama_peminjam'
            )
            ->orderBy('tbl_riwayat_pinjam.created_at', 'desc')
            ->get();

        return view('laporan.index', compact('riwayat'));
    }

    public function cariLaporan(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!$startDate || !$endDate) {
            return back()->with('fail', 'Harap masukkan rentang tanggal yang valid.');
        }

        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $riwayat = DB::table('tbl_riwayat_pinjam')
            ->join('tbl_buku', 'tbl_riwayat_pinjam.id_buku', '=', 'tbl_buku.id')
            ->join('tbl_peminjaman_buku', 'tbl_riwayat_pinjam.id_peminjaman', '=', 'tbl_peminjaman_buku.id')
            ->join('tbl_member', 'tbl_peminjaman_buku.id_member', '=', 'tbl_member.id')
            ->whereBetween('tbl_riwayat_pinjam.tanggal_kembali', [$startDate, $endDate])
            ->select(
                'tbl_riwayat_pinjam.*',
                'tbl_buku.judul',
                'tbl_member.nama as nama_peminjam'
            )
            ->orderBy('tbl_riwayat_pinjam.created_at', 'desc')
            ->get();

        return view('laporan.index', compact('riwayat', 'startDate', 'endDate'));
    }

    // Mencetak laporan ke dalam format PDF
    public function cetakPdf(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if (!$startDate || !$endDate) {
            return back()->with('fail', 'Harap masukkan rentang tanggal yang valid.');
        }

        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $riwayat = DB::table('tbl_riwayat_pinjam')
            ->join('tbl_buku', 'tbl_riwayat_pinjam.id_buku', '=', 'tbl_buku.id')
            ->join('tbl_peminjaman_buku', 'tbl_riwayat_pinjam.id_peminjaman', '=', 'tbl_peminjaman_buku.id')
            ->join('tbl_member', 'tbl_peminjaman_buku.id_member', '=', 'tbl_member.id')
            ->whereBetween('tbl_riwayat_pinjam.tanggal_kembali', [$startDate, $endDate])
            ->select(
                'tbl_riwayat_pinjam.*',
                'tbl_buku.judul',
                'tbl_member.nama as nama_peminjam'
            )
            ->orderBy('tbl_riwayat_pinjam.created_at', 'desc')
            ->get();

        if ($riwayat->isEmpty()) {
            return back()->with('fail', 'Tidak ada data yang ditemukan untuk rentang tanggal tersebut.');
        }

        $pdf = Pdf::loadView('laporan.invoice', compact('riwayat', 'startDate', 'endDate'));
        return $pdf->download('laporan-transaksi.pdf');
    }
}
