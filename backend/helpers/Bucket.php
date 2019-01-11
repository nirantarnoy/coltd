<?php

namespace backend\helpers;

class Bucket
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    private static $data = [
        1 => '200 ลิตร.',
        2 => '300 ลิตร.',
        3 => '450 ลิตร.',
        4 => '800 ลิตร.'

    ];

    private static $dataobj = [
        ['id'=>1,'name' => '200 ลิตร.'],
        ['id'=>2,'name' => '300 ลิตร.'],
        ['id'=>3,'name' => '450 ลิตร.'],
        ['id'=>4,'name' => '800 ลิตร.'],

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
