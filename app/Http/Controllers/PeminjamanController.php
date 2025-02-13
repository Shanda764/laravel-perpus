<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // Menampilkan halaman utama peminjaman
    public function index()
    {
        // Fetch all peminjaman data with related member and book details
        $peminjaman = DB::table('tbl_peminjaman_buku')
            ->join('tbl_member', 'tbl_peminjaman_buku.id_member', '=', 'tbl_member.id')
            ->join('tbl_riwayat_pinjam', 'tbl_peminjaman_buku.id', '=', 'tbl_riwayat_pinjam.id_peminjaman')
            ->join('tbl_buku', 'tbl_riwayat_pinjam.id_buku', '=', 'tbl_buku.id')
            ->select(
                'tbl_peminjaman_buku.*',
                'tbl_member.nama as nama_member',
                'tbl_member.nis',
                'tbl_buku.judul as judul_buku',
                'tbl_riwayat_pinjam.status as status_peminjaman',
                'tbl_riwayat_pinjam.denda'
            )
            ->get(); // Fetch all peminjaman data

        // Fetch the latest peminjaman record with related member and book details
        $latestPeminjaman = DB::table('tbl_peminjaman_buku')
            ->join('tbl_member', 'tbl_peminjaman_buku.id_member', '=', 'tbl_member.id')
            ->join('tbl_riwayat_pinjam', 'tbl_peminjaman_buku.id', '=', 'tbl_riwayat_pinjam.id_peminjaman')
            ->join('tbl_buku', 'tbl_riwayat_pinjam.id_buku', '=', 'tbl_buku.id')
            ->select(
                'tbl_peminjaman_buku.*',
                'tbl_member.nama as nama_member',
                'tbl_member.nis',
                'tbl_buku.judul as judul_buku',
                'tbl_riwayat_pinjam.status as status_peminjaman',
                'tbl_riwayat_pinjam.denda'
            )
            ->latest() // Order by created_at, descending
            ->first(); // Get the most recent record

        return view('peminjaman.index', compact('peminjaman', 'latestPeminjaman'));
    }


    // Memeriksa member berdasarkan NIS
    public function cekMember(Request $request)
    {
        // Validasi inputan NIS
        $request->validate(['nis' => 'required|exists:tbl_member,nis']);

        // Ambil data member berdasarkan NIS
        $member = DB::table('tbl_member')->where('nis', $request->nis)->first();

        // Pastikan member ditemukan
        if (!$member) {
            return redirect()->back()->with('fail', 'Anggota tidak ditemukan.');
        }

        // Cek apakah member masih memiliki peminjaman aktif
        $pinjamAktif = DB::table('tbl_peminjaman_buku')
            ->where('id_member', $member->id)  // Gunakan $member->id
            ->whereNull('tanggal_kembali')  // Masih pinjam (tanggal_kembali null)
            ->exists() ||
            DB::table('tbl_riwayat_pinjam')
            ->join('tbl_peminjaman_buku', 'tbl_riwayat_pinjam.id_peminjaman', '=', 'tbl_peminjaman_buku.id')
            ->where('tbl_peminjaman_buku.id_member', $member->id)  // Gunakan $member->id melalui tbl_peminjaman_buku
            ->where('tbl_riwayat_pinjam.status', 'Dipinjam')  // Status "Dipinjam" masih ada
            ->exists();

        if ($pinjamAktif) {
            return redirect()->back()->with('fail', 'Anda masih memiliki peminjaman aktif. Harap kembalikan buku terlebih dahulu.');
        }

        // Jika tidak ada peminjaman aktif, ambil data buku yang tersedia
        $buku = DB::table('tbl_buku')->where('stok', '>', 0)->get();

        // Tampilkan form peminjaman buku
        return view('peminjaman.pinjam', compact('member', 'buku'));
    }



    // Proses peminjaman buku
    public function pinjamBuku(Request $request)
    {
        $request->validate([
            'id_member' => 'required|exists:tbl_member,id',
            'id_buku' => 'required|array|min:1|max:2', // Maksimal 2 buku
            'id_buku.0' => 'required|exists:tbl_buku,id', // Buku 1 wajib
            'id_buku.1' => 'nullable|exists:tbl_buku,id', // Buku 2 opsional
        ]);

        $id_member = $request->id_member;
        $id_buku = array_filter($request->id_buku);
        // Hapus elemen kosong dari array id_buku
        $id_buku = array_filter($request->id_buku, function ($value) {
            return !is_null($value) && $value !== '';
        });

        try {
            DB::beginTransaction();

            // Simpan data peminjaman
            $id_peminjaman = DB::table('tbl_peminjaman_buku')->insertGetId([
                'id_member' => $id_member,
                'tanggal_kembali' => Carbon::now()->addDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($id_buku as $bukuId) {
                $buku = DB::table('tbl_buku')->where('id', $bukuId)->first();

                // Cek stok buku
                if (!$buku || $buku->stok < 1) {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Stok tidak cukup untuk buku ID: ' . $bukuId);
                }

                // Simpan detail peminjaman ke tbl_riwayat_pinjam
                DB::table('tbl_riwayat_pinjam')->insert([
                    'id_peminjaman' => $id_peminjaman,
                    'id_buku' => $bukuId,
                    'tanggal_kembali' => Carbon::now()->addDays(7),
                    'status' => 'Dipinjam',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Kurangi stok buku
                DB::table('tbl_buku')->where('id', $bukuId)->decrement('stok', 1);
            }

            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
