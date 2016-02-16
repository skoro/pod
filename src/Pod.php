<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

use LogicException;

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
 
    /**
     * Show image in string context.
     */   
    public function __toString()
    {
        return sprintf('"%s" [%s]', $this->title, $imageUrl);
    }
    
    /**
     * Validate POD fields.
     *
     * @throws LogicException
     */
    public function validate()
    {
        if (empty($this->date)) {
            throw new LogicException('date required.');
        }
        
        if (strptime($this->date, '%Y-%m-%d') === false) {
            throw new LogicException('Date must be in format Y-m-d');
        }
        
        if (empty($this->name)) {
            throw new LogicException('Provider name required.');
        }
        
        if (!preg_match('/^https?:\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i', $this->imageUrl)) {
            throw new LogicException('Image url is not valid url.');
        }
    }
    
}
