<?php

namespace backend\helpers;

class OrchardType
{
    const TYPE_A = 1;
    const TYPE_B = 2;
    const TYPE_C = 3;
    private static $data = [
        1 => 'สวนเช่า',
        2 => 'ลูกสวน',
        3 => 'ลูกสวนตัดเอง'
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'สวนเช่า'],
        ['id'=>2,'name' => 'ลูกสวน'],
        ['id'=>3,'name' => 'ลูกสวนตัดเอง'],
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
