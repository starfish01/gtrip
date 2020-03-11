<?php

namespace App\Http\Controllers;

use App\DestinationDetails;
use Illuminate\Http\Request;

class DestinationDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        DestinationDetails::create([
            'title' => 'GC - Freebie Page',
            'url' => 'https://www.gumtree.com.au/s-gold-coast/l3006035r50?ad=offering&price-type=free',
            'search_keys' => json_encode(['mattress', 'free']),
            'enabled' => true
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DestinationDetails  $destinationDetails
     * @return \Illuminate\Http\Response
     */
    public function show(DestinationDetails $destinationDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DestinationDetails  $destinationDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(DestinationDetails $destinationDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DestinationDetails  $destinationDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DestinationDetails $destinationDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DestinationDetails  $destinationDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestinationDetails $destinationDetails)
    {
        //
    }
}
