<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

/**
 * The Telegraph
 *
 * @author skoro
 */
class Telegraph extends Provider
{
    
    /**
     * Picture of the day link.
     */
    protected $url = 'http://www.telegraph.co.uk/news/picturegalleries/picturesoftheday/';
    
    /**
     * @var string
     */
    protected $name = 'telegraph';
    
    /**
     * @inheritdoc
     */
    protected function parsePodDate(DOMDocument $document)
    {
        $date = $document->querySelector('.oneHalf.gutter .summaryBig .dateCC');
        return $date ? $this->parseDate($date->textContent, '%d %b %Y') : '';
    }
    
    /**
     * @inheritdoc
     */
    protected function finalizePod(Pod $pod, DOMDocument $document, $response)
    {
        $img = $document->querySelector('.oneHalf.gutter .piccentre img');
        if (!$img) {
            return;
        }
        
        $src = $img->getAttribute('src');
        // Replace image to high resolution.
        $src = preg_replace('/c\.jpg$/', 'k.jpg', $src);
        $pod->imageUrl = $src;
        
        // Description from the image's "alt" attribute.
        $pod->desc = $img->getAttribute('alt');
        
        // Get direct link to page.
        if ($link = $img->parentNode->getAttribute('href')) {
            $components = parse_url($this->url);
            $pod->baseUrl = $components['scheme'] . '://' . $components['host'] . $link;
        }
    }
    
}
