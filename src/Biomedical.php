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
    protected function parsePodDate(DOMDocument $document)
    {
    }
    
}
