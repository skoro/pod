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
    const URL = 'http://bpod.mrc.ac.uk/';
    
    /**
     * @var string
     */
    protected $name = 'biomedical';
    
    /**
     * @inheritdoc
     */
    protected function remote($date = null)
    {
        $html = $this->httpClient(self::URL);
        $document = $this->createDomDocument($html);
        $pod = $this->createPod();
        
        
        
        return $pod;
    }
    
}
