<?php

namespace backend\helpers;

class Prefixname
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    private static $data = [
        1 => 'นาย',
        2 => 'นางสาว',
        3 => 'นาง',


    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'นาย'],
        ['id'=>2,'name' => 'นางสาว'],
        ['id'=>3,'name' => 'นาง'],


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
