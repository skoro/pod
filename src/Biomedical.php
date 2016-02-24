<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

/**
 * Biomedical
 *
 * @author skoro
 */
class Biomedical extends Provider
{
    
    /**
     * Picture of the day link.
     */
    protected $url = 'http://bpod.mrc.ac.uk/';
    
    /**
     * @var string
     */
    protected $name = 'biomedical';
    
    /**
     * @inheritdoc
     */
    protected function parsePodBaseUrl(DOMDocument $document)
    {
        $meta = $document->getElementsByTagName('meta');
        foreach ($meta as $element) {
            if ($element->getAttribute('name') == 'og:url') {
                return $element->getAttribute('content');
            }
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function finalizePod(Pod $pod, DOMDocument $document, $response)
    {
        $container = $document->querySelector('.container .leftCol .section.main_profile');
        if (!$container) {
            throw new ProviderException('Container wrapper is missing in document.');
        }
        
        foreach ($container->childNodes as $child) {
            if ($child->nodeType != XML_ELEMENT_NODE) {
                continue;
            }
            
            switch ($child->tagName) {
                case 'h1': // title
                    $pod->title = $child->textContent;
                    break;
                    
                case 'h5': // date
                    $pod->date = $this->parseDate($child->textContent, '%d %B %Y');
                    break;
                    
                case 'span': // image url
                    if ($child->hasChildNodes()) {
                        $img = $child->lastChild;
                        if ($img->tagName == 'img') {
                            $src = $img->getAttribute('src');
                            if (($pos = strrpos($src, '?')) !== false) {
                                $src = substr($src, 0, $pos);
                            }
                            $pod->imageUrl = $src;
                        }
                    }
                    break;
                    
                case 'div': // description
                    if (!$pod->desc && $child->hasChildNodes()) {
                        foreach ($child->childNodes as $node) {
                            if ($node->nodeType == XML_ELEMENT_NODE && $node->tagName == 'p') {
                                $pod->desc .= $node->textContent . "\n";
                            }
                        }
                        $pod->desc = trim($pod->desc);
                    }
                    break;
            }
        }
    }
    
}
