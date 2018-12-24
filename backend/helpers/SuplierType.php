<?php

namespace backend\helpers;

class SuplierType
{
    const TYPE_PERSONAL = 1;
    const TYPE_PLANTATION = 2;

    private static $data = [
        1 => 'บุคคล',
        2 => 'สวน'
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'บุคคล'],
        ['id'=>2,'name' => 'สวน']
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
