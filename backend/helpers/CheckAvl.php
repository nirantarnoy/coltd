<?php

namespace backend\helpers;

class CheckAvl
{
    const CHECK_NO = 1;
    const CHECK_WARNING = 2;
    const CHECK_NOT_ALLOW = 3;
    private static $data = [
        1 => 'ไม่เช็ค',
        2 => 'แจ้งเตือน',
        3 => 'ต้องอนุมัติเท่านั้น'
    ];

	private static $dataobj = [
        ['id'=>1,'name' => 'ไม่เช็ค'],
        ['id'=>2,'name' => 'แจ้งเตือน'],
        ['id'=>3,'name' => 'ต้องอนุมัติเท่านั้น'],
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
