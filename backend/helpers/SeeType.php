<?php

namespace backend\helpers;

class SeeType
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    private static $data = [
        1 => 'Social media',
        2 => 'Offline media',
        3 => 'ทีมงานเรา',
        4 => 'เพื่อน/คนรู้จัก แนะนำ',
        5 => 'สังเกตุจากร้านอื่น',

    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'Social media'],
        ['id'=>2,'name' => 'Offline media'],
        ['id'=>3,'name' => 'ทีมงานเรา'],
        ['id'=>4,'name' => 'พื่อน/คนรู้จัก แนะนำ'],
        ['id'=>5,'name' => 'สังเกตุจากร้านอื่น'],

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
