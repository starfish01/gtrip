<?php

namespace App\Http\Controllers;

use App\testtable;
use Illuminate\Http\Request;

class testTableController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
        echo 'hi';
// Project::create($attributes);
testtable::create([
    'title' => 'title',
    'body' => 'body'
]);

        // $this->create([
        //     'body' => 'hi'
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\testtable  $testtable
     * @return \Illuminate\Http\Response
     */
    public function show(testtable $testtable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\testtable  $testtable
     * @return \Illuminate\Http\Response
     */
    public function edit(testtable $testtable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\testtable  $testtable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, testtable $testtable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\testtable  $testtable
     * @return \Illuminate\Http\Response
     */
    public function destroy(testtable $testtable)
    {
        //
    }
}
