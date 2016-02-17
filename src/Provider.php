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
     * Get current picture of the day.
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

        $date = $this->getCurrentDateTime();
        if ($daysAgo !== null) {
            $date->sub(new \DateInterval('P' . (int) $daysAgo . 'D'));
        }
        $date = $date->format('Y-m-d');
        
        if (!($pod = $storage->loadFromDate($this->name, $date))) {
            $pod = $this->remote($daysAgo ? $date : null);
            $pod->validate();
            $storage->save($pod);
        }
        
        return $pod;
    }
    
    /**
     * @return \DateTime
     */
    public function getCurrentDateTime()
    {
        return new \DateTime();
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
     * @return \DOMDocument
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
     * Parse document date to POD date.
     * @param \DOMDocument $document
     * @param string $selector CSS selector with date.
     * @param string $format date format {@link http://docs.php.net/manual/en/function.strftime.php}
     * @throws ProviderException when no date element found or format doesn't to date string.
     * @return string date in format YYYY-MM-DD
     */
    protected function getDateFromDocument(\DOMDocument $document, $selector, $format)
    {
        if (!($elem = $document->querySelector($selector))) {
            throw new ProviderException('Date element node is missing.');
        }
        
        $text = $elem->textContent;
        return $this->parseDate($text, $format);
    }
    
    /**
     * Parse date from a string.
     * @param string $text text contains a date.
     * @param string $format
     * @throws ProviderException
     * @return string
     */
    protected function parseDate($text, $format)
    {
        if (($date = strptime($text, $format)) === false) {
            throw new ProviderException('Date "' . $text . '" does not matched to format: ' . $format);
        }
        
        return sprintf('%d-%02d-%02d', 1900 + $date['tm_year'], $date['tm_mon'] + 1, $date['tm_mday']);
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
