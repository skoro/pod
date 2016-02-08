<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

interface HttpClientInterface
{

    /**
     * Performs http GET request.
     * @return string
     */
    public function get($url);

}
