<?php

namespace backend\helpers;

class WorkTitle
{
    const TYPE_ASSET = 1;
    const TYPE_COMPUTER = 2;
    const TYPE_TOOLS = 3;
    const TYPE_OTHER = 10;

    private static $data = [
        1 => 'Asset',
        2 => 'Computer',
        3 => 'Tools',
        4 => 'Other'

    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'Asset'],
        ['id'=>2,'name' => 'Computer'],
        ['id'=>3,'name' => 'Tools'],
        ['id'=>4,'name' => 'Other'],

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
