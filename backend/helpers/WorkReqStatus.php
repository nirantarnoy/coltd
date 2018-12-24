<?php

namespace backend\helpers;

class WorkReqStatus
{
    const STATUS_CREATE = 1;
    const STATUS_APPROVE = 2;
    const STATUS_PROCESSING = 3;
    const STATUS_COMPLETE = 4;
    const STATUS_REJECT = 5;
    const STATUS_CANCEL = 6;
    const STATUS_REQUEST_CHANGE =7;
    const STATUS_CONVERT_WO =8;


    private static $data = [
        1 => 'Create',
        2 => 'Approve',
        3 => 'Processing',
        4 => 'Complete',
        5 => 'Reject',
        6 => 'Cancel',
        7 => 'Request change',
        8 => 'Generate wo'

    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'Create'],
        ['id'=>2,'name' => 'Approve'],
        ['id'=>3,'name' => 'Processing'],
        ['id'=>4,'name' => 'Complete'],
        ['id'=>5,'name' => 'Reject'],
        ['id'=>6,'name' => 'Cancel'],
        ['id'=>7,'name' => 'Request change'],
        ['id'=>8,'name' => 'Generate wo'],

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
