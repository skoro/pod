<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

/**
 * NationalGeographic.
 *
 * Picture provider for http://photography.nationalgeographic.com
 */
class NationalGeographic extends Provider
{

    /**
     * Picture of the day link.
     */
    const URL = 'http://photography.nationalgeographic.com/photography/photo-of-the-day/';

    /**
     * @inheritdoc
     */
    protected function remote($date = null)
    {
        if ($date !== null) {
            throw new ProviderException('This provider supports only today picture.');
        }
        
        $html = $this->httpRequest(self::URL);
        $document = new DOMDocument();
        $document->loadHTML($html);
    }

}

