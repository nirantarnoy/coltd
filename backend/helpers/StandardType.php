<?php

namespace backend\helpers;

class StandardType
{
    const TYPE_A = 1;
    const TYPE_B = 2;
    const TYPE_C = 3;
    const TYPE_D = 4;
    private static $data = [
        1 => 'GAP',
        2 => 'Global GAP',
        3 => 'Organic',
        4 => 'Fairtrade',
        5 => 'Fair to life',
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'GAP'],
        ['id'=>2,'name' => 'Global GAP'],
        ['id'=>3,'name' => 'Organic'],
        ['id'=>4,'name' => 'Fairtrade'],
        ['id'=>5,'name' => 'Fair to life'],
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
