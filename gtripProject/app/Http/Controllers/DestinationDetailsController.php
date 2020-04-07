<?php

namespace App\Http\Controllers;

use App\DestinationDetails;
use Illuminate\Http\Request;

use App\searchKeys;

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

        $userId = auth()->user()->id;

        DestinationDetails::create([
            'user_id' => $userId,
            'title' => 'GC - Freebie Page',
            'url' => 'https://www.gumtree.com.au/s-gold-coast/l3006035r50?ad=offering&price-type=free',
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

        $userId = auth()->user()->id;

        request()->validate([
            'title' => 'required',
            'url' => 'required'
        ]);

        $newDestination = DestinationDetails::create([
            'user_id' => $userId,
            'title' => request()->title,
            'url' => request()->url,
            'enabled' => false
        ]);

        searchKeys::create([
            'user_id' => $userId,
            'destination_details_id' => $newDestination->id,
            'keys' => '',
            'skip_keys' => ''
        ]);

        return auth()->user()->singleAccessibleDestinations($newDestination->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DestinationDetails  $destinationDetails
     * @return \Illuminate\Http\Response
     */
    public function show(DestinationDetails $destinationDetails)
    {

        $destinations = auth()->user()->accessibleDestinations();

        return ['destinations' => $destinations];
    }

    public function singleItem($id)
    {
        return auth()->user()->singleAccessibleDestinations($id);
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
    public function destroy(DestinationDetails $destinationDetails, $id)
    {

        $deleted = DestinationDetails::where([
            ['user_id', auth()->user()->id],
            ['id', $id]
        ])->delete();

        if ($deleted) {
            return true;
        } 
        abort(404, 'Page not found');
    }

    public function enableDisableDestination(Request $request, $id)
    {
        $enabledPosition = $request['enabledPosition'];

        if ($enabledPosition !== 0 && $enabledPosition !== 1) {
            return 'error';
        }

        DestinationDetails::where([
            ['user_id', auth()->user()->id],
            ['id', $id]
        ])->update(['enabled' => $enabledPosition]);


        return $enabledPosition;
    }
}
