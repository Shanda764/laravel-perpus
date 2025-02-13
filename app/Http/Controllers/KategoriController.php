<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = DB::table('tbl_kategori')->get();

        $title = 'Hapus Data!';
        $text = "Apakah anda yakin?";
        confirmDelete($title, $text);

        return view('Kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateKategori = $request->validate([
            'name' => 'required',
        ]);

        DB::table('tbl_kategori')->insert([
            'name' => $validateKategori['name']
        ]);

        return redirect('kategori')->with('success', 'Data berhasil disimpan :)');
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
        $kategori = DB::table('tbl_kategori')->where('id', $id)->first();

        return view('Kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateKategori = $request->validate([
            'name' => 'required',
        ]);

        DB::table('tbl_kategori')->where('id', $id)->update([
            'name' => $validateKategori['name']
        ]);

        return redirect('kategori')->with('success', 'Data berhasil diubah :)');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tbl_kategori')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus :)');
    }
}
