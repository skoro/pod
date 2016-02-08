<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

/**
 * Picture of the day provider.
 */
abstract class Provider
{

    const YESTERDAY = 1;
    const DAY_BEFORE_YESTERDAY = 2;

    /**
     * @var StorageInterface picture storage.
     */
    protected $storage;
    
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;
    
    /**
     * @var string provider short name.
     */
    protected $name;
    
    /**
     * @param string $name provider name.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param StorageInterface $storage
     * @return Provider
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
        return $this;
    }
    
    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }
    
    /**
     * @param HttpClientInterface $httpClient
     * @return Provider
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }
    
    /**
     * @return HttpClientInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }
    
    /**
     * Get picture of the day.
     * @param integer $daysAgo
     * @throws ProviderException when no storage or/and http client is defined.
     * @return Pod
     */
    public function getPod($daysAgo = null)
    {
        if (!($storage = $this->getStorage())) {
            throw new ProviderException('No picture storage defined.');
        }

        if ($daysAgo === null) {
            $date = date('Y-m-d');
        } else {
            $date = (new \DateTime())
                        ->sub(new \DateInterval('P' . (int) $daysAgo . 'D'))
                        ->format('Y-m-d');
        }
        
        if (!($pod = $storage->fromDate($date))) {
            if (!($http = $this->getHttpClient())) {
                throw new ProviderException('No http client defined.');
            }
            $pod = $this->remote($daysAgo ? $date : null);
            $pod->date = $date;
            $storage->save($pod);
        }
        
        return $pod;
    }
    
    public function createPod($title, $imageUrl, $desc)
    {
        $pod = new Pod();
        $pod->title = $title;
        $pod->imageUrl = $imageUrl;
        $pod->desc = $desc;
        $pod->name = $this->name;
        return $pod;
    }
    
    /**
     * Fetch picture from remote source.
     * Descent classes must implements this method.
     * @param integer $daysAgo
     * @return Pod
     */
    protected function remote($daysAgo = null);
    
}
