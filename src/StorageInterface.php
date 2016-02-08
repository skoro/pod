<?php

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
     * @param integer $date date in format YYYY-MM-DD
     * @return Pod|null
     */
    public function fromDate($date);

}
