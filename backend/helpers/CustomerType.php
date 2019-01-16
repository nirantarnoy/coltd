<?php

namespace backend\helpers;

class CustomerType
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    private static $data = [
        1 => 'ลูกค้าต่างประเภท',
        2 => 'ลูกค้าในประเทศ'

    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'ลูกค้าต่างประเภท'],
        ['id'=>2,'name' => 'ลูกค้าในประเทศ'],

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