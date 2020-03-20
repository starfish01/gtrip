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

        $user = auth()->user()->id;

        $newData = auth()->user()->accessibleDestinations();

        $foundItems = auth()->user()->accessibleFoundItems();

        // $data = DestinationDetails::where([
        //     ['enabled', true],
        //     ['user_id', '=', $user]
        // ])->with('keys')->get();

        return view('home', ['data' => $newData, 'user' => $user, 'foundItems' => $foundItems]);
    }
}
