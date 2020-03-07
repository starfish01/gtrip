<?php

namespace App\Http\Controllers;

use App\testtable;
use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

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


        // $client = new Client();
        // $crawler = $client->request('GET', 'https://www.symfony.com/blog/');
        // $client = new Client(HttpClient::create(['timeout' => 60]));
        // $crawler->filter('h2 > a')->each(function ($node) {
        //     print $node->text() . "\n";
        // });

        testtable::create([
            // 'id' => '836c57b7f3136732d49b9cca4a63461e',
            'title' => 'title',
            'body' => 'body'
        ]);
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
