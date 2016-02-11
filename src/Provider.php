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
     * @throws \LogicException when no storage or/and http client is defined.
     * @throws ProviderException when provider cannot get picture.
     * @return Pod
     */
    public function getPod($daysAgo = null)
    {
        if (!($storage = $this->getStorage())) {
            throw new \LogicException('No picture storage defined.');
        }

        if ($daysAgo === null) {
            $date = date('Y-m-d');
        } else {
            $date = (new \DateTime())
                        ->sub(new \DateInterval('P' . (int) $daysAgo . 'D'))
                        ->format('Y-m-d');
        }
        
        if (!($pod = $storage->loadFromDate($this->name, $date))) {
            $pod = $this->remote($daysAgo ? $date : null);
            $pod->date = $date;
            $storage->save($pod);
        }
        
        return $pod;
    }
    
    /**
     * @param string $title
     * @param string $imageUrl
     * @param string $desc
     * @return Pod
     */
    public function createPod($title = '', $imageUrl = '', $desc = '')
    {
        $pod = new Pod();
        $pod->title = $title;
        $pod->imageUrl = $imageUrl;
        $pod->desc = $desc;
        $pod->name = $this->name;
        return $pod;
    }
    
    /**
     * Create DOM document instance from html text.
     * @param string $html
     * @throws ProviderException when html cannot be parsed.
     * @return DOMDocument
     */
    public function createDomDocument($html)
    {
        libxml_disable_entity_loader(true);
        libxml_use_internal_errors(true);
        
        $document = new DOMDocument();
        $status = $document->loadHTML('<?xml encoding="utf-8"?>' . $html);
        if (!$status) {
            throw new ProviderException('Cannot parse html.');
        }
        
        return $document;
    }
    
    /**
     * Fetch picture from remote source.
     * Descent classes must implements this method.
     * @param string $date optional, fetch remote POD for specific date in format YYYY-MM-DD.
     * @throws ProviderException see descent classes.
     * @return Pod
     */
    abstract protected function remote($date = null);
    
    /**
     * Performs http GET request.
     * @param string $url
     * @throws \LogicException when no http client attached to provider.
     * @throws \Exception when any http client exception occuried.
     * @return string
     */
    protected function httpRequest($url)
    {
        if (!($http = $this->getHttpClient())) {
            throw new \LogicException('No http client defined.');
        }
        
        return $this->httpClient->get($url);
    }
    
}
