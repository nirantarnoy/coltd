<?php

namespace backend\controllers;

use backend\helpers\TransType;
use Yii;
use backend\models\Stockbalance;
use backend\models\StockbalanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * StockbalanceController implements the CRUD actions for Stockbalance model.
 */
class StockbalanceController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Stockbalance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");

        $searchModel = new StockbalanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;


        if(Yii::$app->request->post('hasEditable')){
            $rowid = Yii::$app->request->post('editableKey');
            $stock = Stockbalance::findOne($rowid);
            $out = Json::encode(['output'=>'','message'=>'']);
            $oldqty = $this->findOldqty($rowid);

            // transaction
            $data = [];

            $post = [];
            $posted = current($_POST['Stockbalance']);
            $post['Stockbalance']= $posted;
            if($stock->load($post)){
                $stock_type = 0;
                $newqty = 0;
                if($stock->qty > 0 && $stock->qty != $oldqty){

                    if($stock->qty > $oldqty){
                        $stock_type = 0;
                        $newqty = $stock->qty - $oldqty;
                    }else{
                        $newqty = $oldqty - $stock->qty;
                        $stock_type = 1;
                    }

                }else{

                    return;
                }

                array_push($data,[
                    'prod_id'=>$stock->product_id,
                    'qty'=>$newqty,
                    'warehouse_id'=>1,
                    'trans_type'=> $stock_type == 0?TransType::TRANS_ADJUST_IN:TransType::TRANS_ADJUST_OUT,
                    'permit_no' => $stock->permit_no,
                    'transport_no' => $stock->transport_in_no,
                    'excise_no' => $stock->excise_no,
                ]);
                $output="";
                $out = Json::encode(['output'=>$output,'message'=>'']);

                //if($stock->save()){
                    $update_stock = \backend\models\TransCalculate::createJournal($data);
               // }


            }
            echo $out;
            return;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }
    public function findOldqty($id){
        $model = Stockbalance::findOne($id);
        return count($model)>0?$model->qty:0;
    }

    /**
     * Displays a single Stockbalance model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Stockbalance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stockbalance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Stockbalance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Stockbalance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Stockbalance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stockbalance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stockbalance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
