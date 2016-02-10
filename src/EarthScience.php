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
        
    }

}
