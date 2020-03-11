<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DestinationDetails;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // I want to grab Destination details here and pass it to the view

        $data = DestinationDetails::where('enabled', true)->get();

        return view('home', ['urls' => $data]);
    }
}
