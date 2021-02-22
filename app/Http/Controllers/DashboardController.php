<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Story::where('status', 1);
        $type = $request->input('type');

        if (in_array($type, ['short', 'long'])) {
            $query->where('type', $type);
        }

        $stories = $query->orderBy('id', 'DESC')
            ->paginate(6);
        return view('dashboard.index', [ 'stories' => $stories ]);
    }

    public function show(Story $story)
    {
        return view('dashboard.show', ['story' => $story]);
    }
}
