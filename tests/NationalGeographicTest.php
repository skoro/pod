<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

/**
 * NationalGeographicTest
 */
class NationalGeographicTest extends PODTestCase
{

    public function setUp()
    {
        $this->initProvider(new \skoro\pod\NationalGeographic());
    }
    
    public function testTodayTitle()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('Sweat and Swing', $pod->title);
    }
    
    public function testTodayImageUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('http://images.nationalgeographic.com/wpf/media-live/photos/000/940/cache/muscle-beach-scene_94028_990x742.jpg', $pod->imageUrl);
    }
    
    public function testTodayBaseUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('http://photography.nationalgeographic.com/photography/photo-of-the-day/muscle-beach-scene/', $pod->baseUrl);
    }
    
}
