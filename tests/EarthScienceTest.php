<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

use skoro\pod\Provider;

/**
 * EarthScienceTest
 *
 * @author skoro
 */
class EarthScienceTest extends PODTestCase
{
    
    public function setUp()
    {
        $this->initProvider(new skoro\pod\EarthScience());
    }
    
    public function testToday()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('Orion, the Gibbous Moon and Sirius Observed from Southeastern France', $pod->title);
    }
    
    public function testYesterday()
    {
        $pod = $this->provider->getPod(Provider::YESTERDAY);
    }
    
}
