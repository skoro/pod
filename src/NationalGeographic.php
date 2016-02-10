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
    
    /**
     * Picture title.
     * @param DOMDocument $document
     * @return string
     */
    protected function getPictureTitle(DOMDocument $document)
    {
        if (!($elem = $document->querySelector('#page_head h1'))) {
            throw new ProviderException('Picture title is missing.');
        }
        return $elem->textContent;
    }
    
    /**
     * Get picture direct link.
     * @param DOMDocument $document
     * @return string
     */
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

    /**
     * Get picture text.
     * @param DOMDocument $document
     * @return string
     */
    protected function getPictureInfo(DOMDocument $document)
    {
        $caption = $document->getElementById('caption');
        $text = '';
        if ($caption && $caption->hasChildNodes()) {
            foreach ($caption->childNodes as $child) {
                // Picture description in <p> tags without any attributes (classes, styles, etc).
                if ($child->nodeType !== XML_TEXT_NODE && $child->tagName == 'p'
                    && $child->attributes->length == 0) {
                    $text .= $child->textContent;
                }
            }
        }
        return trim($text);
    }
    
    /**
     * Get url of picture of the day page.
     * @param DOMDocument $document
     * @return string
     */
    protected function getCanonicalUrl(DOMDocument $document)
    {
        $url = '';
        $elements = $document->getElementsByTagName('link');
        foreach ($elements as $elem) {
            $rel = $elem->getAttribute('rel');
            if ($rel == 'canonical') {
                $url = $elem->getAttribute('href');
                break;
            }
        }
        return $url;
    }
    
}

