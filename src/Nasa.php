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

    const POD_API = 'https://api.nasa.gov/planetary/apod';
    
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        parent::__construct('nasa');
    }
    
    /**
     * @inheritdoc
     */
    protected function remote($date = null)
    {
        $query = [
            'api_key' => $this->apiKey,
        ];
        if ($date) {
            $query['date'] = $date;
        }
        $url = static::POD_API . '?' . http_build_query($query);
        
        try {
            $response = $this->httpClient->get($url);
        }
        catch (\Exception $e) {
            throw new ProviderException($e->getMessage());
        }
        
        if (($data = json_decode($response)) === null) {
            throw new ProviderException('Response is not json data.');
        }
        
        return $this->createPod($data->title, $data->url, $data->explanation);
    }

}
