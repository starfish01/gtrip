<?php 

require_once __DIR__ . '/../vendor/autoload.php';

use Goutte\Client;
$client = new Client();

// Go to the symfony.com website
$crawler = $client->request('GET', 'https://www.symfony.com/blog/');

$crawler->filter('h2 > a')->each(function ($node) {
    print $node->text()."\n";
});


echo '1Hello World';

