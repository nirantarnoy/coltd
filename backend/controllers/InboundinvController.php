<?php

namespace backend\controllers;

use Yii;
use backend\models\Inboundinv;
use backend\models\InboundinvSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InboundinvController implements the CRUD actions for Inboundinv model.
 */
class InboundinvController extends Controller
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
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Inboundinv models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new InboundinvSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Inboundinv model.
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
     * Creates a new Inboundinv model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inboundinv();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $prodid = Yii::$app->request->post('productid');
            $lineqty = Yii::$app->request->post('qty');
            $lineprice = Yii::$app->request->post('price');
            $stockid = Yii::$app->request->post('stock_id');

            $model->invoice_date = date('Y/m/d',strtotime($model->invoice_date));
            $model->status = 1;
            if($model->save()){
                if(count($prodid)>0){
                    for($i=0;$i<=count($prodid)-1;$i++){
                        if($prodid[$i]==''){continue;}
                        $modelline = new \backend\models\Inboundinvline();
                        $modelline->invoice_id = $model->id;
                        $modelline->product_id = $prodid[$i];
                        $modelline->line_qty = $lineqty[$i];
                        $modelline->line_price = $lineprice[$i];
                       // $modelline->stock_id = $stockid[$i];
                        $modelline->save();
                    }
                }
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'runno' => $model::getLastNo()
        ]);
    }

    public function actionCreatetrans($id){
        if($id){
            $model = \backend\models\Inboundinvline::find()->where(['invoice_id'=>$id])->all();

            \backend\models\Importline::deleteAll(['import_id'=>$id]);

            if($model){
                foreach ($model as $value){
                    $prodinfo = \backend\models\Product::findProductinfo($value->product_id);
                    $modelimport = new \backend\models\Importline();
                    $modelimport->import_id = $value->invoice_id;
                    $modelimport->product_id = $value->product_id;
                    $modelimport->qty = $value->line_qty;
                    $modelimport->price_per = $value->line_price;
                    $modelimport->total_price = ($value->line_price * $value->line_qty);
                    $modelimport->total_qty = $value->line_qty;
                    $modelimport->line_num = $value->line_num;
                    $modelimport->origin = $prodinfo->origin;
                    $modelimport->position = \backend\models\Product::findGeo($value->product_id);
                    $modelimport->netweight = $prodinfo->netweight;;
                    $modelimport->grossweight = $prodinfo->grossweight;
                    $modelimport->excise_no = $prodinfo->excise_no;
                    $modelimport->save(false);
                }
            }
        }
    }

    /**
     * Updates an existing Inboundinv model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelline = \backend\models\Inboundinvline::find()->where(['invoice_id'=>$id])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelline'=> $modelline,
        ]);
    }

    /**
     * Deletes an existing Inboundinv model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        \backend\models\Inboundinvline::deleteAll(['invoice_id'=>$id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Inboundinv model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inboundinv the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inboundinv::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
