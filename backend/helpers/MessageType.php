<?php

namespace backend\helpers;

class MessageType
{
    const TYPE_PUCHREC = 1;
    private static $data = [
        1 => 'รับวัตถุดิบ',
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'รับวัตถุดิบ'],
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
