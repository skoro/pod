<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 1.0.0
 */

namespace skoro\pod;

use RuntimeException;

/**
 * FileStorage.
 *
 * @author skoro
 */
class FileStorage implements StorageInterface
{
    
    /**
     * @var string
     */
    protected $dir;
    
    /**
     * @param string $dir
     * @throws RuntimeException when directory cannot be created.
     */
    public function __construct($dir)
    {
        $this->createDir($dir);
        $this->dir = $dir;
    }
    
    protected function createDir($dir)
    {
        $dir = implode(DIRECTORY_SEPARATOR, func_get_args());
        if (!is_dir($dir) && !mkdir($dir)) {
            throw new RuntimeException("Couldn't create directory: $dir");
        }
        return $dir;
    }
    
    /**
     * @inheritdoc
     */
    public function loadFromDate($name, $date)
    {
        $filename = $this->dir . DIRECTORY_SEPARATOR . $name .
                DIRECTORY_SEPARATOR . $date . '.data';
        if (!file_exists($filename)) {
            return null;
        }
        
        $data = @file_get_contents($filename);
        if ($data === false) {
            throw new RuntimeException("Couldn't read file: $filename");
        }
        
        return unserialize($data);
    }

    /**
     * @inheritdoc
     */
    public function save(Pod $pod)
    {
        $dir = $this->createDir($this->dir, $pod->name);
        $filename = $dir . DIRECTORY_SEPARATOR . $pod->date . '.data';
        $data = serialize($pod);
        if (!@file_put_contents($filename, $data)) {
            throw new RuntimeException("Couldn't create file: $filename");
        }
    }

}
