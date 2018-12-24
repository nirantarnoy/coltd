<?php

namespace backend\helpers;

class DeliveryType
{
    const ROAD_TYPE = 1;
    const TRAIN_TYPE = 2;
    const SEA_TYPE = 3;
    const AIR_TYPE = 4;
    const OTHER_TYPE = 5;
    private static $data = [
        1 => 'รถยนต์',
        2 => 'รถไฟ',
        3 => 'เรีอ',
        4 => 'เครื่องบิน',
        5 => 'อื่นๆ',
    ];

	private static $dataobj = [
        ['id'=>1,'name' => 'รถยนต์'],
        ['id'=>2,'name' => 'รถไฟ'],
        ['id'=>3,'name' => 'เรีอ'],
        ['id'=>4,'name' => 'เครื่องบิน'],
        ['id'=>5,'name' => 'อื่นๆ'],
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
