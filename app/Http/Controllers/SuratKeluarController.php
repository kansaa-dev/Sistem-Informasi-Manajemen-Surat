<?php

namespace App\Http\Controllers;

use App\Models\OutgoingLetter;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    // Menampilkan daftar surat keluar
    public function index()
    {
        $suratKeluar = OutgoingLetter::orderBy('id', 'desc')->get();

        return view('surat-keluar.index', compact('suratKeluar'));
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('surat-keluar.create');
    }

    // Menyimpan surat keluar
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        OutgoingLetter::create($validated);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    // Menampilkan detail surat
    public function show($id)
    {
        $surat = OutgoingLetter::findOrFail($id);

        return view('surat-keluar.show', compact('surat'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $surat = OutgoingLetter::findOrFail($id);

        return view('surat-keluar.edit', compact('surat'));
    }

    // Memperbarui surat
    public function update(Request $request, $id)
    {
        $surat = OutgoingLetter::findOrFail($id);

        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    // Menghapus surat
    public function destroy($id)
    {
        $surat = OutgoingLetter::findOrFail($id);

        $surat->delete();

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }
}