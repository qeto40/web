<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        // Eager load skills
        $members = Member::with(['skills', 'user'])
            ->where('verified', true)
            ->where('availability', true)
            ->get();

        return response()->json($members);
    }

    public function show($slug)
    {
        // Eager load everything needed for the profile page
        $member = Member::with([
            'user', 
            'skills', 
            'services', 
            'portfolios' => function ($query) {
                $query->where('status', 'approved')->with('images');
            }
        ])->where('slug', $slug)->firstOrFail();

        return response()->json($member);
    }
}
