<?php

namespace backend\helpers;

class AutController
{
    const CONTROLLER_PLANT = 1;
    const CONTROLLER_USERGROUP = 2;
    const CONTROLLER_USER = 3;
    const CONTROLLER_DEPARTMENT = 4;

    private static $data = [
        1 => 'plant',
        2 => 'usergroup',
        3 => 'user',
        4 => 'department'
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'plant'],
        ['id'=>2,'name' => 'usergroup'],
        ['id'=>3,'name' => 'user'],
        ['id'=>4,'name' => 'department'],
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
