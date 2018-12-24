<?php

namespace backend\helpers;

class TeamType
{
    const TEAM_A = 1;
    const TEAM_B = 2;

    private static $data = [
        1 => 'ทีมตัด',
        2 => 'ทีมขน'

    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'ทีมตัด'],
        ['id'=>2,'name' => 'ทีมขน'],
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
