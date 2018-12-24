<?php

namespace backend\helpers;

class QcTitle
{
    const TYPE_A = 1;
    const TYPE_B = 2;
    const TYPE_C = 3;
    const TYPE_D = 4;
    const TYPE_E = 5;
    const TYPE_F = 6;
    const TYPE_G = 7;
    const TYPE_H = 8;
    private static $data = [
        1 => 'เล็กตกไซต์',
        2 => 'เล็กควบ 2',
        3 => 'เล็กจิ๋ว',
        4 => 'ลูกช้ำ',
        5 => 'แก่',
        6 => 'อ่อน',
        7 => 'ปากกา',
        8 => 'มะพร้าวกลาย',
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'เล็กตกไซต์'],
        ['id'=>2,'name' => 'เล็กควบ 2'],
        ['id'=>3,'name' => 'เล็กจิ๋ว'],
        ['id'=>4,'name' => 'ลูกช้ำ'],
        ['id'=>5,'name' => 'แก่'],
        ['id'=>6,'name' => 'อ่อน'],
        ['id'=>7,'name' => 'ปากกา'],
        ['id'=>8,'name' => 'มะพร้าวกลาย'],
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
