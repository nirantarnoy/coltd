<?php

namespace backend\controllers;

use backend\models\PickinglineSearch;
use backend\models\QuerybalanceSearch;
use backend\models\TransCalculate;
use Yii;
use backend\models\Sale;
use backend\models\SaleSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use backend\helpers\TransType;

/**
 * SaleController implements the CRUD actions for Sale model.
 */
class ReportController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Sale models.
     * @return mixed
     */
    public function actionIndex()
    {
       return $this->render('_balance');
    }
    public function actionBalance(){
        $searchModel = new QuerybalanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       return $this->render('_balance',[
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
       ]);
    }
}
