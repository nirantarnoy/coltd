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
