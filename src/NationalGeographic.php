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
    protected $url = 'http://photography.nationalgeographic.com/photography/photo-of-the-day/';
    
    /**
     * @var string
     */
    protected $name = 'nationalgeographic';

    /**
     * @inheritdoc
     */
    protected function parsePodDate(DOMDocument $document)
    {
        return $this->getDateFromDocument($document, '#pod_right .publication_time', '%B %d, %Y');
    }
    
    /**
     * @inheritdoc
     */
    protected function parsePodTitle(DOMDocument $document)
    {
        if (!($elem = $document->querySelector('#page_head h1'))) {
            throw new ProviderException('Picture title is missing.');
        }
        return $elem->textContent;
    }
    
    /**
     * @inheritdoc
     */
    protected function parsePodImageUrl(DOMDocument $document)
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
     * @inheritdoc
     */
    protected function parsePodDesc(DOMDocument $document)
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
     * @inheritdoc
     */
    protected function parsePodBaseUrl(DOMDocument $document)
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

