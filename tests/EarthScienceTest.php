<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

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
    
    public function testTitle()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('Orion, the Gibbous Moon and Sirius Observed from Southeastern France', $pod->title);
    }
    
    public function testDate()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('2016-02-10', $pod->date);
    }
    
    public function testImageUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('http://epod.usra.edu/.a/6a0105371bb32c970b01b8d196a956970c-pi', $pod->imageUrl);
    }
    
    public function testBaseUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('http://epod.usra.edu/blog/2016/02/orion-the-gibbous-moon-and-sirius-observed-from-southeastern-france.html', $pod->baseUrl);
    }
    
}
