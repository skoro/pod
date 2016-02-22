<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

/**
 * Euronews
 *
 * Picture provider for http://www.euronews.com/
 * 
 * @author skoro
 */
class Euronews extends Provider
{

    /**
     * Picture of the day link.
     */
    protected $url = 'http://www.euronews.com/picture-of-the-day/';

    /**
     * @var string
     */
    protected $name = 'euronews';
    
    /**
     * @inheritdoc
     */
    protected function finalizePod(Pod $pod, DOMDocument $document, $response)
    {
        // Wrapper element for date and base url.
        $element = $document->querySelector('#potd-list-wrap .new-row a.selected');
        if ($element && $element->hasChildNodes()) {
            // Create absolute url from relative.
            $href = parse_url($element->getAttribute('href'));
            if (empty($href['scheme'])) {
                $url = parse_url($this->url);
                $pod->baseUrl = $url['scheme'] . '://' . $url['host'] . $href['path'];
            }
            // Search date element.
            foreach ($element->childNodes as $child) {
                if ($child->nodeType == XML_ELEMENT_NODE && 
                        $child->getAttribute('class') == 'date') {
                    $pod->date = $this->parseDate($child->textContent, '%d/%m/%Y');
                    break;
                }
            }
        }
        
        // Wrapper element for title, image url and description.
        $element = $document->getElementById('potd-wrap');
        if ($element && $element->hasChildNodes()) {
            foreach ($element->childNodes as $child) {
                if ($child->nodeType == XML_ELEMENT_NODE) {
                    switch ($child->tagName) {
                        case 'h1' :
                            if (empty($pod->title)) {
                                $pod->title = $child->textContent;
                            }
                            break;

                        case 'div' :
                            if ($child->getAttribute('id') == 'image-caption') {
                                $pod->desc = $child->textContent;
                            }
                            break;

                        case 'img' :
                            $pod->imageUrl = $child->getAttribute('src');
                            if (($pos = strpos($pod->imageUrl, '?')) !== false) {
                                $pod->imageUrl = substr($pod->imageUrl, 0, $pos);
                            }
                            break;
                    }
                }
            }
        }
        
    }
 
}

