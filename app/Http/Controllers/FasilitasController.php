<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::latest()->paginate(10);
        return view('fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('fasilitas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'ikon' => 'nullable|string|max:255',
        ]);

        Fasilitas::create($validated);

        return redirect()->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Fasilitas $fasilita)
    {
        return view('fasilitas.edit', compact('fasilita'));
    }

    public function update(Request $request, Fasilitas $fasilita)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'ikon' => 'nullable|string|max:255',
        ]);

        $fasilita->update($validated);

        return redirect()->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Fasilitas $fasilita)
    {
        $fasilita->delete();

        return redirect()->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }
}
