<?php

namespace backend\helpers;

class PlanType
{
    const PLAN_TIME_BASE = 1;
    const PLAN_METER_BASE = 2;
    private static $data = [
        1 => 'Time base',
        2 => 'Meter base'
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'Time base'],
        ['id'=>2,'name' => 'Meter base'],
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
