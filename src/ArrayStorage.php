<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

/**
 * ArrayStorage.
 * 
 * Store PODs in array.
 */
class ArrayStorage implements StorageInterface
{

    /**
     * @var Pod[]
     */
    protected $pods = [];

    /**
     * @inheritdoc
     */
    public function loadFromDate($name, $date)
    {
        $key = $this->podKey($name, $date);
        return isset($this->pods[$key]) ? $this->pods[$key] : null;
    }

    /**
     * @inheritdoc
     */
    public function save(Pod $pod)
    {
        $this->pods[$this->podKey($pod->name, $pod->date)] = $pod;
    }
    
    /**
     * Get POD key.
     * @param string $name provider name.
     * @param string $date picture date in format YYYY-MM-DD
     */
    protected function podKey($name, $date)
    {
        return $name . '-' . $date;
    }

    /**
     * @return Pod[]
     */
    public function getPods()
    {
        return $this->pods;
    }

}

