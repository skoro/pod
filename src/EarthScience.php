<?php

/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

/**
 * EarthScience
 *
 * Picture provider for http://epod.usra.edu/
 * 
 * @author skoro
 */
class EarthScience extends Provider {

    /**
     * Picture of the day link.
     */
    protected $url = 'http://epod.usra.edu/';

    /**
     * @var string
     */
    protected $name = 'usra';

    /**
     * @inheritdoc
     */
    protected function parsePodDate(DOMDocument $document) {
        return $this->getDateFromDocument($document, '#alpha-inner .entry .date', '%B %d, %Y');
    }

    /**
     * @inheritdoc
     */
    protected function parsePodImageUrl(DOMDocument $document) {
        $elem = $document->querySelector('#alpha-inner div.entry-body a.asset-img-link');
        return $elem ? $elem->getAttribute('href') : '';
    }

    /**
     * @inheritdoc
     */
    protected function parsePodTitle(DOMDocument $document)
    {
        $elem = $document->querySelector('#alpha-inner h3.entry-header a');
        return $elem ? $elem->textContent : '';
    }
    
    /**
     * @inheritdoc
     */
    protected function parsePodBaseUrl(DOMDocument $document)
    {
        $elem = $document->querySelector('#alpha-inner h3.entry-header a');
        return $elem ? $elem->getAttribute('href') : '';
    }

    /**
     * @inheritdoc
     */
    protected function parsePodDesc(DOMDocument $document) {
        $desc = '';
        $divs = $document->querySelectorAll('#alpha-inner div.entry-body div');
        if ($divs) {
            foreach ($divs as $div) {
                $desc .= $div->textContent . PHP_EOL;
            }
        }
        return $desc;
    }

}
