<?php

namespace backend\helpers;

class ProspectStatus
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    private static $data = [
        1 => 'รออนุมัติ',
        2 => 'อนุมัติแล้ว',


    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'รออนุมัติ'],
        ['id'=>2,'name' => 'อนุมัติแล้ว'],


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
