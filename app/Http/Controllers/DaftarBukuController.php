<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DaftarBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $buku = DB::table('tbl_buku')
            ->join('tbl_kategori', 'tbl_buku.kategori_id', '=', 'tbl_kategori.id')
            ->select('tbl_buku.*', 'tbl_kategori.name as namaKategori')
            ->orderBy('created_at', 'DESC')
            ->get();

        $title = 'Hapus Data!';
        $text = "Apakah anda yakin?";
        confirmDelete($title, $text);
        return view('daftar_buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = DB::table('tbl_kategori')->get();
        return view('daftar_buku.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'kategori_id' => 'required|exists:tbl_kategori,id',
            'lokasi' => 'required',
            'stok' => 'required',
        ]);

        // Proses upload gambar
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar_buku', 'public');
        }
        $kode = "KD" . date('d') . time();

        DB::table('tbl_buku')->insert([
            'kode' => $kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'gambar' => $gambarPath,
            'kategori_id' => $request['kategori_id'],
            'lokasi' => $request->lokasi,
            'stok' => $request->stok,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('daftar_buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ambil data buku berdasarkan ID
        $buku = DB::table('tbl_buku')->where('id', $id)->first();
        $kategori = DB::table('tbl_kategori')->get();
        // Periksa apakah data buku ditemukan
        if (!$buku) {
            return redirect()->route('daftar_buku.index')->with('error', 'Data buku tidak ditemukan.');
        }

        // Tampilkan halaman edit dengan data buku
        return view('daftar_buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'kode' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'kategori_id' => 'required|exists:tbl_kategori,id',
            'lokasi' => 'required',
            'stok' => 'required'
        ]);

        // Ambil data buku berdasarkan ID
        $buku = DB::table('tbl_buku')->where('id', $id)->first();

        if (!$buku) {
            return redirect()->route('daftar_buku.index')->with('error', 'Buku tidak ditemukan.');
        }

        // Proses upload gambar baru (jika ada)
        $gambarPath = $buku->gambar; // Path gambar sebelumnya
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($gambarPath) {
                Storage::disk('public')->delete($gambarPath);
            }
            // Upload gambar baru
            $gambarPath = $request->file('gambar')->store('gambar_buku', 'public');
        }

        $kode = "KD" . date('d') . time();

        DB::table('tbl_buku')->where('id', $id)->update([
            'kode' => $kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'gambar' => $gambarPath,
            'kategori_id' => $request['kategori_id'],
            'lokasi' => $request->lokasi,
            'stok' => $request->stok,
            'updated_at' => now()
        ]);

        return redirect()->route('daftar_buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil data buku untuk menghapus gambar dari storage
        $buku = DB::table('tbl_buku')->where('id', $id)->first();

        // Hapus gambar dari storage jika ada
        if ($buku && $buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }

        // Hapus data buku dari database
        DB::table('tbl_buku')->where('id', $id)->delete();

        return redirect()->route('daftar_buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
