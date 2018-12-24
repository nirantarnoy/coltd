<?php

namespace backend\helpers;

class Workpriority
{
    const TYPE_NORMAL = 1;
    const TYPE_URGENT = 2;
    const TYPE_EMERGENCY = 3;

    private static $data = [
        1 => 'Normal',
        2 => 'Urgent',
        3 => 'Emergency'

    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'Normal'],
        ['id'=>2,'name' => 'Urgent'],
        ['id'=>3,'name' => 'Emergency'],

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
