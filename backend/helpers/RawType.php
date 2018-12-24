<?php

namespace backend\helpers;

class RawType
{
    const TYPE_A = 1;
    const TYPE_B = 2;
    private static $data = [
        1 => 'ลูกเขียว',
        2 => 'ลูกสำเร็จ'
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'ลูกเขียว'],
        ['id'=>2,'name' => 'ลูกสำเร็จ'],
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
