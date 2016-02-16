<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

/**
 * EuronewsTest
 *
 * @author skoro
 */
class EuronewsTest extends PODTestCase
{
    
    public function setUp()
    {
        $this->initProvider(new skoro\pod\Euronews());
    }
    
    public function testTitle()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('Gaga over Bowie', $pod->title);
    }
    
    public function testDate()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('2016-02-16', $pod->date);
    }
    
    public function testImageUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('http://static.euronews.com/articles/324370/924x617_324370.jpg', $pod->imageUrl);
    }
    
    public function testBaseUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('http://www.euronews.com/picture-of-the-day/2016/02/16/gaga-over-bowie/', $pod->baseUrl);
    }
    
}
