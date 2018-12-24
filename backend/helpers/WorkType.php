<?php

namespace backend\helpers;

class WorkType
{
    const TYPE_GENERAL = 1;
    const TYPE_CORRECTIVE = 2;
    const TYPE_PREVENTIVE = 3;
    const TYPE_BREAKDOWN = 4;
    const TYPE_INSPECTION = 5;
    const TYPE_PROJECT = 6;

    private static $data = [
        1 => 'General',
        2 => 'Corrective',
        3 => 'Preventive',
        4 => 'Breakdown',
        5 => 'Inspection',
        6 => 'Project'
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'General'],
        ['id'=>2,'name' => 'Corrective'],
        ['id'=>3,'name' => 'Preventive'],
        ['id'=>4,'name' => 'Breakdown'],
        ['id'=>5,'name' => 'Inspection'],
        ['id'=>6,'name' => 'Project'],
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
