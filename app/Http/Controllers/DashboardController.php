<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\County;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $counties = County::query()
            ->withCount('cities')
            ->orderBy('name')
            ->get();

        $cities = City::query()
            ->with('county:id,name')
            ->orderBy('name')
            ->get();

        return view('dashboard', [
            'counties' => $counties,
            'cities' => $cities,
        ]);
    }
}
