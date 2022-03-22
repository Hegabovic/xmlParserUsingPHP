<?php


class IndexHandler
{
    private static $index;

    /**
     * @return mixed
     */
    public static function getIndex()
    {
        return self::$index;
    }

    /**
     * @param mixed $index
     */
    public static function setIndex($index)
    {
        self::$index = $index;
    }

    public static function boundariesCheck($index, $size)
    {
        if ($index >= $size) {
            $index = 1;
        } else if ($index <= 0) {
            $index = $size;
        }
        return $index;
    }


}
