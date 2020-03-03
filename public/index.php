<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$products = ['tv', 'dyson', 'printer', 'elvis'];
$listItems = [];
$foundItems = [];

// Go to the symfony.com website
$crawler = $client->request('GET', 'https://www.gumtree.com.au/s-gold-coast/l3006035r50?ad=offering&price-type=free');

// Creates an array of item titles
$listItems[] = $crawler->filter('.user-ad-row__title')->each(function ($node, $i) {
    // We are currently only grabbing the title I will need to grab 
    // the whole add and then get the url and the title from there
    $newitem = $node->text();
    return $newitem;
});
$listItems = $listItems[0];

// Loop though items and search for key items
foreach ($listItems as $item) {
    foreach ($products as $searchingFor) {
        if (strpos(strtolower($item), $searchingFor) !== false) {
            $foundItems[] = $item;
        }
    }
}



header('Content-type: application/json');
echo json_encode([
    'result' => array_values($foundItems),
    'error' => null
]);
