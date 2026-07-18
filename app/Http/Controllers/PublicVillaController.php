<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use Illuminate\Http\Request;

class PublicVillaController extends Controller
{
    public function index(Request $request)
    {
        $villas = Villa::all();

        $recentData = session()->get('recent_villas', []);
        $recentIds = array_keys($recentData);

        $recentVillas = !empty($recentIds)
            ? Villa::whereIn('id', $recentIds)->get()->sortByDesc(function ($model) use ($recentData) {
                return $recentData[$model->id] ?? 0;
            })
            : collect();

        return view('customer.pages.villa', compact('villas', 'recentVillas'));
    }

    public function show(Villa $villa)
    {
        $villa->load(['galleries', 'rooms', 'fasilitas']);
        $related = Villa::where('id', '!=', $villa->id)->take(3)->get();

        // Save to recent history in session
        $recent = session()->get('recent_villas', []);
        $recent[$villa->id] = now()->timestamp;
        arsort($recent);
        $recent = array_slice($recent, 0, 10, true);
        session()->put('recent_villas', $recent);

        return view('customer.pages.villa-detail', compact('villa', 'related'));
    }

    public function search(Request $request)
    {
        $query = Villa::query();
        
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%");
        }
        
        if ($request->filled('sort')) {
            if ($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort == 'newest') {
                $query->latest();
            }
        }
        
        $villas = $query->get();
        return view('customer.pages.villa-search', compact('villas'));
    }

    public function clearHistory()
    {
        session()->forget('recent_villas');
        return back();
    }
}
