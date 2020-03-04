<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$products = ['tv', 'dyson'];
$listItems = [];
$foundItems = [];

// Go to the symfony.com website
$crawler = $client->request('GET', 'https://www.gumtree.com.au/s-gold-coast/l3006035r50?ad=offering&price-type=free');

// Creates an array of item titles
$listItems[] = $crawler->filter('.user-ad-row')->each(function ($node, $i) {

    $item = [];
    $item['title'] = $node->filter('.user-ad-row__title')->text();
    $item['url'] = $node->attr('href');
    $item['id'] = md5($item['url']);
    $item['createdAt'] = $node->filter('.user-ad-row__age')->text();
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
            $foundItems[] = $item;
        }
    }
}

phpinfo();

// header('Content-type: application/json');
// echo json_encode([
//     'result' => array_values($foundItems),
//     'error' => null
// ]);
