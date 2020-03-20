<?php

namespace App\Http\Controllers;

use App\GumTreeRipper;
use Illuminate\Http\Request;
use Goutte\Client;
use App\Http\Controllers\Controller;
use \Mailjet\Resources;
use DB;

use App\DestinationDetails;




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

        foreach ($newItems as $item) {
            GumTreeRipper::create([
                'title' => $item['title'],
                'url' => $item['url'],
                'item_id' => $item['id'],
                'createdAt' => $item['createdAt'],
                'location' => $item['location'],
                'distance' => $item['distance'],
                'suburb' => $item['suburb'],
                'filtered_out' =>  $item['filtered_out'],
                'user_id' =>  $item['user_id']
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

    public function capture()
    {

        $itemsToSearch = DestinationDetails::where('enabled', true)->get();

        foreach ($itemsToSearch as $item) {
            $this->getGumtreeData($item['url'], json_decode($item['keys']['keys']),  json_decode($item['keys']['skip_keys']), $item['user_id']);
        }
    }

    public function getGumtreeData($url, $products, $filterOut, $userId)
    {

        $listItems = [];
        $foundItems = [];

        $client = new Client();
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);

        // Creates an array of item titles
        $listItems[] = $crawler->filter('.user-ad-row')->each(function ($node, $i) use (&$userId) {

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
            $item['filtered_out'] = false;
            $item['user_id'] = $userId;
            return $item;
        });

        $listItems = $listItems[0];

        $foundItems = $this->findItemsMatchingKeys($listItems, $products);

        if (count($foundItems) === 0) {
            return;
        }

        // Mark found items that need to be filtered out 
        $filterApplied = $this->filterOutItems($foundItems, $filterOut);

        $this->store($filterApplied);

        $this->sendEmails();
    }

    public function filterOutItems($foundItems, $filterOut)
    {
        $returnItems = [];

        // Loop though items and search for key items
        foreach ($foundItems as $item) {
            foreach ($filterOut as $searchingFor) {
                if (strpos(strtolower($item['title']), $searchingFor) !== false) {
                    $item['filtered_out'] = true;
                }
                $returnItems[] = $item;
            }
        }
        return $returnItems;
    }


    public function findItemsMatchingKeys($listItems, $products)
    {
        $returnFound = [];

        // Loop though items and search for key items
        foreach ($listItems as $item) {
            foreach ($products as $searchingFor) {
                if (strpos(strtolower($item['title']), $searchingFor) !== false) {
                    if (!GumTreeRipper::where('item_id', '=', $item['id'])->exists()) {
                        $returnFound[] = $item;
                    }
                }
            }
        }

        return $returnFound;
    }

    public function sendEmails()
    {
        // get items from db marked not sent
        $itemsToEmail = GumTreeRipper::where([['email_sent', false], ['filtered_out', false]])->get();

        if (count($itemsToEmail) === 0) {
            return;
        }


        $message = '';

        // format into a message
        foreach ($itemsToEmail as $item) {

            $url = 'https://www.gumtree.com.au' . $item['url'];

            $message .= '<p>' . "<a href='" . $url . "' target='_blank'>" . $item['title'] . '</a></p>';
            $message .= '<p>Created at:' . $item['createdAt'] . '</p>';
            $message .= '<p>' . $item['location'] . '</p>';
            $message .= '<p>' . $item['distance'] . '</p>';
            $message .= '<p>' . $item['suburb'] . '</p>';
            $message .= '<hr>';
        }

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
                            'Name' => "Patrick Labes"
                        ]
                    ],
                    'Subject' => "Deals Found",
                    'HTMLPart' => $message,
                ]
            ]
        ];

        var_dump('blah');

        $response = $mj->post(Resources::$Email, ['body' => $body]);
        // Read the response
        $response->success() && var_dump($response->getData());

        GumTreeRipper::where([['email_sent', false], ['filtered_out', false]])->update(['email_sent' => true]);
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
