<?php
namespace console\controllers;
use yii\console\Controller;

class BackupController extends Controller {
    public function actionBackup()
    {
        $backup = \Yii::$app->backup;
        $databases = ['db', 'db1', 'db2'];
        foreach ($databases as $k => $db) {
            $index = (string)$k;
            $backup->fileName = 'myapp-part';
            $backup->fileName .= str_pad($index, 3, '0', STR_PAD_LEFT);
            $backup->directories = [];
            $backup->databases = [$db];
            $file = $backup->create();
            $this->stdout('Backup file created: ' . $file . PHP_EOL, \yii\helpers\Console::FG_GREEN);
        }
    }
}


?>
