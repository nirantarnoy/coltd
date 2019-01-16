<?php

namespace backend\helpers;

class TransType
{
    const TRANS_ISSUE = 1;
    const TRANS_RETURN = 2;
    const TRANS_ADJUST = 3;
    const TRANS_TRANSFER = 4;
    const TRANS_COUNT = 5;
    const TRANS_QUOTATION = 6;
    const TRANS_SALEORDER = 7;
    const TRANS_PICKING = 8;
    const TRANS_PACKING = 9;
    const TRANS_INVOICE = 10;

    private static $data = [
        1 => 'เบิก',
        2 => 'คืน',
        3 => 'ปรับยอด',
        4 => 'ย้าย',
        5 => 'นับสต๊อก',
        6 => 'เสนอราคา',
        7 => 'ขาย',
        8 => 'picking',
        9 => 'packing slip',
        10 => 'invoice',
    ];

	private static $dataobj = [
        ['id'=>1,'name' => 'เบิก'],
        ['id'=>2,'name' => 'คืน'],
        ['id'=>3,'name' => 'ปรับยอด'],
        ['id'=>4,'name' => 'ย้าย'],
        ['id'=>5,'name' => 'นับสต๊อก'],
        ['id'=>6,'name' => 'เสนอราคา'],
        ['id'=>7,'name' => 'ขาย'],
        ['id'=>8,'name' => 'picking'],
        ['id'=>9,'name' => 'packing slip'],
        ['id'=>10,'name' => 'invoice'],
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
