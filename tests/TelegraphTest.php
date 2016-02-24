<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

/**
 * TelegraphTest
 *
 * @author skoro
 */
class TelegraphTest extends PODTestCase
{
    
    public function setUp()
    {
        $this->initProvider(new skoro\pod\Telegraph());
    }
    
    public function testTitle()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('', $pod->title);
    }
    
    public function testDate()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('2016-02-21', $pod->date);
    }
    
    public function testImageUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('http://i.telegraph.co.uk/multimedia/archive/03579/POTD_Openbill_stor_3579628k.jpg', $pod->imageUrl);
    }
    
    public function testBaseUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('http://www.telegraph.co.uk/news/picturegalleries/picturesoftheday/12166751/Pictures-of-the-day-21-February-2016.html', $pod->baseUrl);
    }
    
    public function testDesc()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('An Openbill stork flies over Pobitora wetland wildlife sanctuary on the outskirts of Gauhati, India.', $pod->desc);
    }
    
}
