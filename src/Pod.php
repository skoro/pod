<?php

namespace skoro\pod;

/**
 * Picture of the day entity.
 */
class Pod
{

    /**
     * @var string date of picture in format YYYY-MM-DD
     */
    public $date;
    
    /**
     * @var string provider's name.
     */
    public $name;
    
    /**
     * @var string image title.
     */
    public $title;
    
    /**
     * @var string description text.
     */
    public $desc;
    
    /**
     * @var string
     */
    public $imageUrl;

    /**
     * @var string url to image resource (site page).
     */
    public $baseUrl;
    
}

