<?php

namespace backend\helpers;

class PermissionType
{
    const TYPE_ADMIN = 1;
    const TYPE_USER = 2;
    const TYPE_MANAGER = 3;
    private static $data = [
        1 => 'System Administrator',
        2 => 'System User',
        3 => 'Manager'
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'System Administrator'],
        ['id'=>2,'name' => 'System User'],
        ['id'=>3,'name' => 'Manager'],
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
