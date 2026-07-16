<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use Illuminate\Http\Request;

class PublicVillaController extends Controller
{
    public function index()
    {
        $villas = Villa::all();
        return view('pages.villa', compact('villas'));
    }

    public function show(Villa $villa)
    {
        $villa->load(['galleries', 'rooms', 'fasilitas']);
        $related = Villa::where('id', '!=', $villa->id)->take(3)->get();
        return view('pages.villa-detail', compact('villa', 'related'));
    }
}
