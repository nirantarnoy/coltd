<?php

namespace backend\helpers;

class TransType
{
    const TRANS_ISSUE = 1;
    const TRANS_RETURN = 2;
    const TRANS_ADJUST = 3;
    const TRANS_TRANSFER = 4;
    const TRANS_COUNT = 5;
    
    private static $data = [
        1 => 'เบิก',
        2 => 'คืน',
        3 => 'ปรับยอด',
        4 => 'ย้าย',
        5 => 'นับสต๊อก'
    ];

	private static $dataobj = [
        ['id'=>1,'name' => 'เบิก'],
        ['id'=>2,'name' => 'คืน'],
        ['id'=>3,'name' => 'ปรับยอด'],
        ['id'=>4,'name' => 'ย้าย'],
        ['id'=>5,'name' => 'นับสต๊อก'],
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
