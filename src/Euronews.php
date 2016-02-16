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
    const URL = 'http://www.euronews.com/picture-of-the-day/';
    
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct('euronews');
    }
    
    /**
     * @inheritdoc
     */
    protected function remote($date = null)
    {
        $html = $this->httpRequest(self::URL);
        $document = $this->createDomDocument($html);
        
        $pod = $this->createPod();
        $pod->date = $this->getDateFromDocument($document, '#potd-list-wrap .new-row .date', '%d/%m/%Y');
        
        $element = $document->getElementById('potd-wrap');
        if (!$element) {
            throw new ProviderException('Wrapper element not found.');
        }
        
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
        
        return $pod;
    }
 
}

