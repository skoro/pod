<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

/**
 * NationalGeographic.
 *
 * Picture provider for http://photography.nationalgeographic.com
 */
class NationalGeographic extends Provider
{

    /**
     * Picture of the day link.
     */
    const URL = 'http://photography.nationalgeographic.com/photography/photo-of-the-day/';

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct('nationalgeographic');
    }

    /**
     * @inheritdoc
     */
    protected function remote($date = null)
    {
        if ($date !== null) {
            throw new ProviderException('This provider supports only today picture.');
        }
        
        $html = $this->httpRequest(self::URL);
        $document = $this->createDomDocument($html);
        
        $pod = $this->createPod();
        $pod->title = $this->getPictureTitle($document);
        $pod->imageUrl = $this->getPictureUrl($document);
        $pod->desc = $this->getPictureInfo($document);
        $pod->baseUrl = $this->getCanonicalUrl($document);
        
        return $pod;
    }
    
    protected function getPictureTitle(DOMDocument $document)
    {
        if (!($elem = $document->querySelector('#page_head h1'))) {
            throw new ProviderException('Picture title is missing.');
        }
        return $elem->textContent;
    }
    
    protected function getPictureUrl(DOMDocument $document)
    {
        if (!($elem = $document->querySelector('#content_top .primary_photo img'))) {
            throw new ProviderException('Picture is missing');
        }
        $src = $elem->getAttribute('src');
        if (strpos($src, '//') === 0) {
            $src = 'http:' . $src;
        }
        return $src;
    }

    protected function getPictureInfo(DOMDocument $document)
    {
        $elem = $document->querySelector('#caption');
        return '';
    }
    
    protected function getCanonicalUrl(DOMDocument $document)
    {
    }
    
}

