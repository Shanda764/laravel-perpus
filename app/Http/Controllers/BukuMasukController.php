<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data buku masuk beserta relasi ke tabel buku untuk mendapatkan judul buku
        $bukuMasuk = DB::table('tbl_masuk_buku')
            ->join('tbl_buku', 'tbl_masuk_buku.buku_id', '=', 'tbl_buku.id')
            ->select('tbl_masuk_buku.*', 'tbl_buku.judul as judul')
            ->get();

        return view('bukuMasuk.index', compact('bukuMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil daftar buku untuk digunakan dalam dropdown saat menambahkan data buku masuk
        $buku = DB::table('tbl_buku')->get();
        return view('bukuMasuk.create', compact('buku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'buku_id' => 'required|exists:tbl_buku,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'required'
        ]);

        // Tambahkan data ke tbl_masuk_buku
        $id = DB::table('tbl_masuk_buku')->insertGetId([
            'buku_id' => $request->buku_id,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' =>$request->keterangan,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Update stok di tbl_buku
        DB::table('tbl_buku')
            ->where('id', $request->buku_id)
            ->increment('stok', $request->jumlah);

        return redirect()->route('bukuMasuk.index')->with('success', 'Data buku masuk berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ambil data buku masuk berdasarkan ID
        $bukuMasuk = DB::table('tbl_masuk_buku')->where('id', $id)->first();

        // Jika data tidak ditemukan, kembalikan 404
        if (!$bukuMasuk) {
            abort(404, 'Data tidak ditemukan');
        }

        // Ambil daftar buku
        $buku = DB::table('tbl_buku')->get();

        return view('bukuMasuk.edit', compact('bukuMasuk', 'buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'buku_id' => 'required|exists:tbl_buku,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'required',
        ]);

        // Ambil data buku masuk sebelumnya
        $bukuMasuk = DB::table('tbl_masuk_buku')->where('id', $id)->first();

        if (!$bukuMasuk) {
            abort(404, 'Data tidak ditemukan');
        }

        // Hitung selisih jumlah buku
        $selisihJumlah = $request->jumlah - $bukuMasuk->jumlah;

        // Perbarui data buku masuk
        DB::table('tbl_masuk_buku')->where('id', $id)->update([
            'buku_id' => $request->buku_id,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
            'updated_at' => now()
        ]);

        // Perbarui stok di tbl_buku
        DB::table('tbl_buku')
            ->where('id', $request->buku_id)
            ->increment('stok', $selisihJumlah);

        return redirect()->route('bukuMasuk.index')->with('success', 'Data buku masuk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil data buku masuk berdasarkan ID
        $bukuMasuk = DB::table('tbl_masuk_buku')->where('id', $id)->first();

        if (!$bukuMasuk) {
            abort(404, 'Data tidak ditemukan');
        }

        // Hapus data dari tbl_masuk_buku
        DB::table('tbl_masuk_buku')->where('id', $id)->delete();

        // Kurangi stok dari tbl_buku
        DB::table('tbl_buku')
            ->where('id', $bukuMasuk->buku_id)
            ->decrement('stok', $bukuMasuk->jumlah);

        return redirect()->route('bukuMasuk.index')->with('success', 'Data buku masuk berhasil dihapus');
    }
}
