<?php

namespace skoro\pod;

interface HttpClientInterface
{

    /**
     * Performs http GET request.
     * @return array on success returns array with two elements: 'content-type',
     *               'response'.
     */
    public function get($url);

}
