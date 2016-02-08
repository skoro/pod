<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

/**
 * NASA provider.
 */
class Nasa extends Provider
{

    const POD_API = '';

    public function __construct($apiKey)
    {
        parent::__construct('nasa');
    }
    
    protected function remote($daysAgo = null)
    {
        $url = static::POD_API . '?' . http_build_query(['api_key' => $this->apiKey]);
        $response = $this->httpClient->get($url);
    }

}
