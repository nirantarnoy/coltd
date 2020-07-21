<?php

namespace backend\controllers;

use Yii;
use backend\models\Picking;
use backend\models\PickingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Modelfile;
use yii\web\UploadedFile;

/**
 * PickingController implements the CRUD actions for Picking model.
 */
class DbrestoreController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionBak(){
//        $host="localhost";
//        $username="root";
//        $password="";
//        $dbname="coltd";
//
//        $con = mysqli_connect($host, $username, $password) or die("ไม่สามารถเชื่อมต่อฐานข้อมูลได้");
//        mysqli_select_db($con,$dbname) or die("ฐานข้อมูลไม่ถูกต้อง");
//        $sql = ("mysqldump -u root -p $dbname > D:\COLTD_BAK\db.sql");
//        exec($sql);
        $this->backup_tables('localhost','root','','coltd');
    }
    public function backup_tables($host,$user,$pass,$name,$tables = '*')
    {

        $link = mysqli_connect($host,$user,$pass);
        mysqli_set_charset($link,"utf8");

        mysqli_select_db($link,$name);

        $return = '';

        //get all of the tables
        if($tables == '*')
        {
            $tables = array();
            $result = mysqli_query($link,'SHOW TABLES');
            while($row = mysqli_fetch_row($result))
            {
                $tables[] = $row[0];
            }
        }
        else
        {
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }

        //cycle through
        foreach($tables as $table)
        {
            $result = mysqli_query($link,'SELECT * FROM '.$table);
            $num_fields = mysqli_num_fields($result);

            $return.= 'DROP TABLE '.$table.';';
            $row2 = mysqli_fetch_row(mysqli_query($link,'SHOW CREATE TABLE '.$table));
            $return.= "\n\n".$row2[1].";\n\n";

            for ($i = 0; $i < $num_fields; $i++)
            {
                while($row = mysqli_fetch_row($result))
                {
                    $return.= 'INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j<$num_fields; $j++)
                    {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                        if ($j<($num_fields-1)) { $return.= ','; }
                    }
                    $return.= ");\n";
                }
            }
            $return.="\n\n\n";
        }

        //save file
        $handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
        fwrite($handle,$return);
        fclose($handle);
    }
    /**
     * Lists all Picking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Modelfile();
        if($model->load(Yii::$app->request->post())){
           $uploaded = UploadedFile::getInstance($model,'file');
           if(!empty($uploaded)){
               $uploaded->saveAs(Yii::getAlias('@backend') .'/backups/'.$uploaded);
               $this->redirect(['db-manager/default']);
           }
        }

        return $this->render('index', [
            'modelfile'=>$model
        ]);
    }


    /**
     * Displays a single Picking model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

}
