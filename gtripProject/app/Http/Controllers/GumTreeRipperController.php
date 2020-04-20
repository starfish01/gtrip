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
                'user_id' =>  $item['user_id'],
                'destination_details_id' => $item['destination_details_id']
            ]);
        }
    }

    public function capture()
    {

        $itemsToSearch = DestinationDetails::where('enabled', true)->get();

        foreach ($itemsToSearch as $item) {

            $keys = $item['keys']['keys'] ? explode(",", $item['keys']['keys']) : [];
            $skip_keys = $item['keys']['skip_keys'] ? explode(",", $item['keys']['skip_keys']) : [];
            $this->getGumtreeData($item['url'], $keys,  $skip_keys, $item['user_id'], $item['id']);
        }
    }

    public function getGumtreeData($url, $products, $filterOut, $userId, $destination_details_id)
    {

        $listItems = [];
        $foundItems = [];

        $client = new Client();

        $crawler = $client->request('GET', $url);

        $dataToUse = [
            'uid' => $userId,
            'did' => $destination_details_id
        ];

        // Creates an array of item titles
        $listItems[] = $crawler->filter('.user-ad-row')->each(function ($node, $i) use (&$dataToUse) {

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
            $item['user_id'] = $dataToUse['uid'];
            $item['destination_details_id'] = $dataToUse['did'];

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

        if (!count($filterOut)) {
            return $foundItems;
        }

        // Loop though items and search for key items
        foreach ($foundItems as $item) {
            foreach ($filterOut as $searchingFor) {
                if (strpos(strtolower($item['title']), strtolower($searchingFor)) !== false) {
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

        if (!count($products)) {
            foreach ($listItems as $item) {
                if (!GumTreeRipper::where('item_id', '=', $item['id'])->exists()) {
                    $returnFound[] = $item;
                }
            }
        } else {
            // Loop though items and search for key items
            foreach ($listItems as $item) {
                foreach ($products as $searchingFor) {
                    if (strpos(strtolower($item['title']), strtolower($searchingFor)) !== false) {
                        if (!GumTreeRipper::where('item_id', '=', $item['id'])->exists()) {
                            $returnFound[] = $item;
                        }
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
                        'Name' => 'Gumtree - ' . $itemsToEmail[0]['title']
                    ],
                    'To' => [
                        [
                            'Email' => "patrick.labes@gmail.com",
                            'Name' => "Patrick Labes"
                        ]
                    ],
                    'Subject' => "Deals Found - " . $item['distance'],
                    'HTMLPart' => $message,
                ]
            ]
        ];

        $response = $mj->post(Resources::$Email, ['body' => $body]);
        // Read the response
        $response->success() && var_dump($response->getData());

        GumTreeRipper::where([['email_sent', false], ['filtered_out', false]])->update(['email_sent' => true]);
    }

    public function getDate(String $date)
    {
        date_default_timezone_set('Australia/Brisbane');
        $currentTime = date('Y-m-d H:i');

        // check for minute
        if (strpos($date, 'minutes')) {
            $minutesToRemove = explode(' ', trim($date))[0];
            $returnTime = date('Y-m-d H:i', strtotime('-' . $minutesToRemove . ' minutes', strtotime($currentTime)));
            return $returnTime;
        } else if (strpos($date, 'hour')) {
            $hoursToRemove = explode(' ', trim($date))[0];
            $returnTime = date('Y-m-d H:i', strtotime('-' . $hoursToRemove . ' hour', strtotime($currentTime)));
            return $returnTime;
        } else if (strpos($date, 'yesterday')) {
            $returnTime = date('Y-m-d H:i', strtotime('-1 day', strtotime($currentTime)));
            return $returnTime;
        } else {
            // its a date
            return $date;
        }
    }
}
