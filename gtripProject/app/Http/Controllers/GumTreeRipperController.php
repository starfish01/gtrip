<?php

namespace App\Http\Controllers;

use App\GumTreeRipper;
use Illuminate\Http\Request;
use Goutte\Client;
use App\Http\Controllers\Controller;
use \Mailjet\Resources;




class GumTreeRipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('home');
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
    public function store($newItems)
    {
        //
        // $newItems = $this->getGumtreeData();


        foreach ($newItems as $item) {
            GumTreeRipper::create([
                'title' => $item['title'],
                'url' => $item['url'],
                'item_id' => $item['id'],
                'createdAt' => $item['createdAt'],
                'location' => $item['location'],
                'distance' => $item['distance'],
                'suburb' => $item['suburb']
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GumTreeRipper  $gumTreeRipper
     * @return \Illuminate\Http\Response
     */
    public function show(GumTreeRipper $gumTreeRipper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GumTreeRipper  $gumTreeRipper
     * @return \Illuminate\Http\Response
     */
    public function edit(GumTreeRipper $gumTreeRipper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GumTreeRipper  $gumTreeRipper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GumTreeRipper $gumTreeRipper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GumTreeRipper  $gumTreeRipper
     * @return \Illuminate\Http\Response
     */
    public function destroy(GumTreeRipper $gumTreeRipper)
    {
        //
    }

    public function getGumtreeData()
    {
        $products = ['mattress'];
        $listItems = [];
        $foundItems = [];

        $client = new Client();
        // Go to the symfony.com website
        $crawler = $client->request('GET', 'https://www.gumtree.com.au/s-gold-coast/l3006035r50?ad=offering&price-type=free');

        // Creates an array of item titles
        $listItems[] = $crawler->filter('.user-ad-row')->each(function ($node, $i) {

            // convert time possible results = yesterday hours minutes an actual date

            $dateOfCreation = $this->getDate($node->filter('.user-ad-row__age')->text());

            // TODO remove item earlier rather then in the next loop

            $item = [];
            $item['title'] = $node->filter('.user-ad-row__title')->text();
            $item['url'] = $node->attr('href');
            $item['id'] = md5($item['url']);
            $item['createdAt'] = $dateOfCreation;
            $item['location'] = $node->filter('.user-ad-row__location .user-ad-row__location-area')->text();
            $item['distance'] = $node->filter('.user-ad-row__location .user-ad-row__distance')->text();
            $item['suburb'] = str_replace($item['distance'], '', str_replace($item['location'], '', $node->filter('.user-ad-row__location')->text()));

            return $item;
        });

        $listItems = $listItems[0];

        // Loop though items and search for key items
        foreach ($listItems as $item) {
            foreach ($products as $searchingFor) {
                if (strpos(strtolower($item['title']), $searchingFor) !== false) {
                    if (!GumTreeRipper::where('item_id', '=', $item['id'])->exists()) {
                        $foundItems[] = $item;
                    }
                }
            }
        }

        if (count($foundItems) === 0) {
            return;
        }

        $this->store($foundItems);

        $this->sendEmails();
    }

    public function sendEmails()
    {
        // get items from db marked not sent
        // format into a message



        $mj = new \Mailjet\Client(getenv('MAILJET_APIKEY'), getenv('MAILJET_APISECRET'), true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mailer@mail.patricklabes.com.au",
                        'Name' => "Mailer"
                    ],
                    'To' => [
                        [
                            'Email' => "patrick.labes@gmail.com",
                            'Name' => "You"
                        ]
                    ],
                    'Subject' => "My first Mailjet Email!",
                    'TextPart' => "Greetings from Mailjet!",
                    'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href=\"https://www.mailjet.com/\">Mailjet</a>!</h3>
            <br />May the delivery force be with you!"
                ]
            ]
        ];

        $response = $mj->post(Resources::$Email, ['body' => $body]);
        // Read the response
        $response->success() && var_dump($response->getData());
    }

    public function getDate(String $date)
    {
        date_default_timezone_set('Australia/Brisbane');
        $currentTime = date("d/m/y H:i");

        // check for minute
        if (strpos($date, 'minutes')) {
            $minutesToRemove = explode(' ', trim($date))[0];
            $returnTime = date('d/m/y H:i', strtotime('-' . $minutesToRemove . ' minutes', strtotime($currentTime)));
            return $returnTime;
        } else if (strpos($date, 'hour')) {
            $hoursToRemove = explode(' ', trim($date))[0];
            $returnTime = date('d/m/y H:i', strtotime('-' . $hoursToRemove . ' hour', strtotime($currentTime)));
            return $returnTime;
        } else if (strpos($date, 'yesterday')) {
            $returnTime = date('d/m/y H:i', strtotime('-1 day', strtotime($currentTime)));
            return $returnTime;
        } else {
            // its a date
            return $date;
        }
    }
}
