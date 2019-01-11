<?php

namespace backend\helpers;

class item
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    private static $data = [
        1 => 'หลอดใหญ่ 20 กก.',
        2 => 'หลอดเล็ก 20 กก.',
        3 => 'บด 20 กก.',
        4 => 'แพ็ค 1.25 กก.'

    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'หลอดใหญ่ 20 กก.'],
        ['id'=>2,'name' => 'หลอดเล็ก 20 กก.'],
        ['id'=>3,'name' => 'บด 20 กก.'],
        ['id'=>4,'name' => 'แพ็ค 1.25 กก.'],

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
