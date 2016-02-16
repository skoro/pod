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
class EarthScience extends Provider
{
    
    /**
     * Picture of the day link.
     */
    const URL = 'http://epod.usra.edu/';
    
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct('usra');
    }
    
    /**
     * @inheritdoc
     */
    protected function remote($date = null)
    {
        $html = $this->httpRequest(self::URL);
        $document = $this->createDomDocument($html);
        
        $pod = $this->createPod();
 
        $pod->date = $this->getDateFromDocument($document, '#alpha-inner .entry .date', '%B %d, %Y');
        
        // Title and base url.
        if (!($elem = $document->querySelector('#alpha-inner h3.entry-header a'))) {
            throw new ProviderException('Cannot get title and base url.');
        }
        $pod->baseUrl = $elem->getAttribute('href');
        $pod->title = $elem->textContent;

        // Image url.
        $elem = $document->querySelector('#alpha-inner div.entry-body a.asset-img-link');
        if (!$elem) {
            throw new ProviderException('Cannot get image element.');
        }
        $pod->imageUrl = $elem->getAttribute('href');
        
        // Optional. Description.
        $divs = $document->querySelectorAll('#alpha-inner div.entry-body div');
        if ($divs) {
            foreach ($divs as $div) {
                $pod->desc .= $div->textContent . PHP_EOL;
            }
        }
        
        return $pod;
    }

}
