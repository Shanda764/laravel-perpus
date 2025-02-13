<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = DB::table('tbl_member')
            ->orderBy('created_at', 'DESC')
            ->get();

        $title = 'Hapus Data!';
        $text = "Apakah anda yakin?";
        confirmDelete($title, $text);
        return view('Member.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Member.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'email' => 'nullable|email|max:100|unique:tbl_member,email',
            'tanggal_daftar' => 'required|date_format:Y-m-d',
            'status' => 'required|in:siswa,guru',
            'nis' => 'required|unique:tbl_member,nis', // Validasi untuk nis yang unik
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ], [
            'nis.unique' => 'NIS Anda sudah terdaftar. Mohon gunakan NIS lain.',
        ]);

        if ($request->hasFile('gambar')) {
            $foto = $request->file('gambar')->store('Foto', 'public');
        } else {
            $foto = null; // Jika tidak ada gambar yang diunggah
        }

        $kode_member = 'KD' . date('dHis');

        DB::table('tbl_member')->insert([
            'kode_member' => $kode_member,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status' => $request->status,
            'nis' => $request->nis,
            'gambar' => $foto,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function show(string $id)
    {
        // Menggunakan Query Builder untuk mengambil data berdasarkan id
        $member = DB::table('tbl_member')
            ->select('kode_member', 'nama', 'nis', 'alamat', 'no_telepon', 'tanggal_daftar', 'gambar')
            ->where('id', $id)
            ->first(); // Mengambil data pertama yang ditemukan berdasarkan ID

        // Cek jika member ditemukan
        if ($member) {
            // Mengembalikan data ke view
            return view('member.cetakMember', compact('member'));
        } else {
            // Jika member tidak ditemukan
            return redirect()->route('members.index')->with('error', 'Member not found');
        }
    }
    public function edit($id)
    {
        $member = DB::table('tbl_member')->where('id', $id)->first();

        if (!$member) {
            return redirect()->route('member.index')->with('error', 'Member tidak ditemukan.');
        }

        return view('Member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'email' => 'nullable|email|max:100|unique:tbl_member,email,' . $id,
            'tanggal_daftar' => 'required|date_format:Y-m-d',
            'status' => 'required|in:siswa,guru',
            'nis' => 'required|unique:tbl_member,nis,' . $id, // Memastikan nis yang diupdate tetap unik
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ], [
            'nis.unique' => 'NIS Anda sudah terdaftar. Mohon gunakan NIS lain.',
        ]);

        $member = DB::table('tbl_member')->where('id', $id)->first();

        if (!$member) {
            return redirect()->route('member.index')->with('error', 'Member tidak ditemukan.');
        }

        $foto = $member->gambar; // Path gambar sebelumnya
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($foto) {
                Storage::disk('public')->delete($foto);
            }
            // Upload gambar baru dan mendapatkan path gambar yang baru
            $foto = $request->file('gambar')->store('gambar_member', 'public');
        }

        DB::table('tbl_member')->where('id', $id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status' => $request->status,
            'nis' => $request->nis,
            'gambar' => $foto,
            'updated_at' => now()
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $member = DB::table('tbl_member')->where('id', $id)->first();

        if (!$member) {
            return redirect()->route('member.index')->with('error', 'Member tidak ditemukan.');
        }

        DB::table('tbl_member')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function cetakMember($id)
    {
        // Mengambil data member berdasarkan ID menggunakan Query Builder
        $member = DB::table('tbl_member')->where('id', $id)->first();

        // Jika data member tidak ditemukan, redirect ke halaman index
        if (!$member) {
            return redirect()->route('member.index')->with('error', 'Member tidak ditemukan.');
        }

        // Load view kartu_member.blade.php dan passing data member ke view
        $pdf = PDF::loadView('Member.cetakMember', compact('member'));


        return $pdf->download('kartu_member_' . $member->kode_member . '.pdf');
    }
}
