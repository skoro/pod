<?php
require __DIR__ . '/vendor/autoload.php';

use skoro\pod\ArrayStorage;
use skoro\pod\NationalGeographic;
use skoro\pod\HttpClientInterface;

class MiniHttpClient implements HttpClientInterface
{
    public function get($url)
    {
        return file_get_contents($url);
    }
}

$ng = new NationalGeographic();
$ng->setStorage(new ArrayStorage());
$ng->setHttpClient(new MiniHttpClient());
$pod = $ng->getPod();
var_dump($pod);

