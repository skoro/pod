<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

use skoro\pod\HttpClientInterface;

/**
 * FakeHttpClient
 *
 * @author skoro
 */
class FakeHttpClient implements HttpClientInterface
{
    
    public function get($url)
    {
        $file = str_replace('http://', '', $url);
        $file = substr($file, 0, strpos($file, '/'));
        $file .= '.html';
        $file = dirname(__FILE__) . '/files/' . $file;
        return file_get_contents($file);
    }

}
