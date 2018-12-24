<?php

namespace backend\helpers;

class Workflowtype
{
    const TYPE_WO = 1;
    const TYPE_PR = 2;
    private static $data = [
        1 => 'ใบสั่งงาน',
        2 => 'ขอซื้อ'
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'ใบสั่งงาน'],
        ['id'=>2,'name' => 'ขอซื้อ'],
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
