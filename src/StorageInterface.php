<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

interface StorageInterface
{

    /**
     * Save Pod entity to storage.
     * @param Pod $pod entity
     */
    public function save(Pod $pod);
    
    /**
     * Get Pod entity from defined date.
     * @param string $name provider name.
     * @param integer $date date in format YYYY-MM-DD
     * @return Pod|null
     */
    public function loadFromDate($name, $date);

}
