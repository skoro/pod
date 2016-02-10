<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

use skoro\pod\Provider;

/**
 * PODTestCase
 *
 * @author skoro
 */
class PODTestCase extends PHPUnit_Framework_TestCase
{
    
    /**
     * @var Provider
     */
    protected $provider;
    
    public function initProvider(Provider $provider)
    {
        $this->provider = $provider;
        $this->provider->setHttpClient(new FakeHttpClient());
        $this->provider->setStorage(new skoro\pod\ArrayStorage());
    }
    
}
