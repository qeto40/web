<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with(['member.user', 'images'])
            ->where('status', 'approved')
            ->get();

        return response()->json($portfolios);
    }

    public function show($slug)
    {
        $portfolio = Portfolio::with(['member.user', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json($portfolio);
    }
}
