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
    protected function finalizePod(Pod $pod, DOMDocument $document, $response)
    {
        $container = $document->querySelector('.container .leftCol .section.main_profile');
        if (!$this->container) {
            throw new ProviderException('Container wrapper is missing in document.');
        }
        
        foreach ($container->childNodes as $child) {
            if ($child->nodeType != XML_ELEMENT_NODE) {
                continue;
            }
        }
    }
    
}
