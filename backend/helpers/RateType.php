<?php

namespace backend\helpers;

class RateType
{
    const ROLE = 1;
    const RULE = 2;
    private static $data = [
        1 => 'ในประเทศ',
        2 => 'ต่างประเทศ'
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'ในประเทศ'],
        ['id'=>2,'name' => 'ต่างประเทศ'],
    ];
    public static function asArray()
    {
        return self::$data;
    }
    public static function asArrayObject()
    {
        return self::$dataobj;
    }
    public static function getTypeById($idx)
    {
        if (isset(self::$data[$idx])) {
            return self::$data[$idx];
        }

        return 'Unknown Type';
    }
    public static function getTypeByName($idx)
    {
        if (isset(self::$data[$idx])) {
            return self::$data[$idx];
        }

        return 'Unknown Type';
    }
}
