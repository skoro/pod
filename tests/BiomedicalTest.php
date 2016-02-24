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
        $this->assertEquals('http://s3.amazonaws.com/mrc-bpod-production/imgs/1786/profile/BPoD-Adventures_of_Titin_18.2.16.jpg', $pod->imageUrl);
    }
    
    public function testBaseUrl()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals('http://bpod.mrc.ac.uk/archive/2016/2/18', $pod->baseUrl);
    }
    
    public function testDesc()
    {
        $pod = $this->provider->getPod();
        $this->assertEquals("Your heart beats, thanks in part to a protein called titin. Someone born with a titin gene shortened by mutation will have a weaker heart, a condition called dilated cardiomyopathy. Disease severity varies from patients needing heart transplants to others living with milder symptoms. Differences are down to where on the gene the mutation occurs, with mutations near the start of the gene causing milder symptoms. Scientists genetically engineered zebrafish to have differently located mutations and found that severe cardiomyopathy was linked to mutations near a ‘failsafe’ region of the gene. This region normally codes for a separate smaller version of titin, which helps alleviate symptoms when mutations happen near the start of the gene. But if mutations happen at or after the failsafe region, small titin is badly made and symptoms are severe. Pictured are zebrafish embryos expressing small (top) and normal titin (bottom) in the heart muscle (arrowed).\nWritten by Gaëlle Coullon", $pod->desc);
    }
    
}
