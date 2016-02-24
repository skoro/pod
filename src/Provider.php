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

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;
    
    /**
     * @var string provider short name.
     */
    protected $name;
    
    /**
     * @var string link to a picture of the day resource.
     */
    protected $url;
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        if (empty($this->name)) {
            throw new \LogicException('Provider name must be already initialized.');
        }
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
    public function getPod()
    {
        $response = $this->httpRequest($this->url);
        $document = $this->createDomDocument($response);
        $this->beforeParsePod($document, $response);
        $pod = $this->createPod();
        $pod->title = $this->parsePodTitle($document);
        $pod->date = $this->parsePodDate($document);
        $pod->imageUrl = $this->parsePodImageUrl($document);
        $pod->desc = $this->parsePodDesc($document);
        $pod->baseUrl = $this->parsePodBaseUrl($document);
        $this->finalizePod($pod, $document, $response);
        $pod->validate();
        return $pod;
    }
    
    /**
     * @param string $title
     * @param string $imageUrl
     * @param string $desc
     * @return Pod
     */
    protected function createPod($title = '', $imageUrl = '', $desc = '')
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
    protected function createDomDocument($html)
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
     * @param DOMDocument $document
     * @return string
     */
    protected function parsePodTitle(DOMDocument $document)
    {
        return '';
    }
    
    /**
     * @param DOMDocument $document
     * @return string
     */
    protected function parsePodDate(DOMDocument $document)
    {
        return '';
    }
    
    /**
     * @param DOMDocument $document
     * @return string
     */
    protected function parsePodImageUrl(DOMDocument $document)
    {
        return '';
    }
    
    /**
     * @param DOMDocument $document
     * @return string
     */
    protected function parsePodDesc(DOMDocument $document)
    {
        return '';
    }
    
    protected function parsePodBaseUrl(DOMDocument $document)
    {
        return '';
    }
    
    /**
     * Invokes before parsing document.
     * @param DOMDocument $document
     * @param string $response
     */
    protected function beforeParsePod(DOMDocument $document, &$response)
    {
        
    }
    
    /**
     * Invokes before validating Pod instance.
     * @param Pod $pod
     * @param DOMDocument $document
     * @param string $response
     */
    protected function finalizePod(Pod $pod, DOMDocument $document, $response)
    {
        
    }
    
    /**
     * Parse document date to POD date.
     * @param DOMDocument $document
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
