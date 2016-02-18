<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

/**
 * BiomedicalTest
 *
 * @author skoro
 */
class BiomedicalTest extends PODTestCase
{
    
    public function setUp()
    {
        $this->initProvider(new skoro\pod\Biomedical());
    }
    
    public function testTitle()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('Adventures of Titin', $pod->title);
    }
    
    public function testDate()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('2016-02-18', $pod->date);
    }
    
    public function testImageUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('src="http://s3.amazonaws.com/mrc-bpod-production/imgs/1786/profile/BPoD-Adventures_of_Titin_18.2.16.jpg"', $pod->imageUrl);
    }
    
    public function testBaseUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('http://bpod.mrc.ac.uk/archive/2016/2/18', $pod->baseUrl);
    }
    
}
