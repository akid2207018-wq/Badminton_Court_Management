<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class CourtController extends Controller
{
    public function index(Request $request): View
    {
        $query = Court::available();

        // Search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Price filter
        if ($request->filled('max_price')) {
            $query->where('price_per_hour', '<=', $request->max_price);
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Sort
        $sort = $request->get('sort', 'name');
        $dir  = $request->get('dir', 'asc');
        $allowedSorts = ['name', 'price_per_hour', 'location'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $dir === 'desc' ? 'desc' : 'asc');
        }

        $courts = $query->paginate(9)->withQueryString();

        return view('courts.index', compact('courts'));
    }

    public function show(Court $court): View
    {
        abort_if(!$court->isAvailable(), 404);

        Cookie::queue('last_court', $court->name, 7 * 24 * 60);

        return view('courts.show', compact('court'));
    }
}
