<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use App\Models\Partnership;
use App\Models\User;
use App\Models\Donator;
use App\Models\Volunteer;
use App\Models\Dependence;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homepage = null;
        $carousels = Carousel::where('status',1)->orderBy('created_at','desc')->get();
        $partnershipCount = Partnership::count();
        $memberCount = User::count();
        $donaturCount = Donator::count();
        $volunteerCount = Volunteer::count();
        $fiveLatestTestimony = Dependence::with('user:id,name')->latest()->take(5)->get();

        $homepage['carousels'] = $carousels;
        $homepage['partnershipCount'] = $partnershipCount;
        $homepage['memberCount'] = $memberCount;
        $homepage['donaturCount'] = $donaturCount;
        $homepage['volunteerCount'] = $volunteerCount;
        $homepage['fiveLatestTestimony'] = $fiveLatestTestimony;
        return response()->json($homepage);
    }

}
