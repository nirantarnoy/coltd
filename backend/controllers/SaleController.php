<?php

namespace backend\controllers;

use backend\models\PickinglineSearch;
use Yii;
use backend\models\Sale;
use backend\models\SaleSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SaleController implements the CRUD actions for Sale model.
 */
class SaleController extends Controller
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
     * Lists all Sale models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new SaleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Sale model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modelline = \backend\models\Saleline::find()->where(['sale_id'=>$id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelline' => $modelline
        ]);
    }

    /**
     * Creates a new Sale model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sale();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 1;
            if($model->save()){
                return $this->redirect(['update', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'runno' => $model::getLastNo(),
        ]);
    }

    /**
     * Updates an existing Sale model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelline = \backend\models\Saleline::find()->where(['sale_id'=>$id])->all();

        $pickinglist = [];


        $modelpick = \backend\models\Picking::find()->all();
//        if($modelpick){
//            foreach($modelpick as $value){
//                array_push($pickinglist,$value->id);
//            }
//        }
//        if(count($pickinglist)>0){
//            $dataProvider = \backend\models\Pickingline::find()->where(['picking_id'=>$pickinglist])->all();
//
//           // $dataProvider->query->andFilterWhere(['picking_id'=>$pickinglist]);
//        }else{
//            $dataProvider = \backend\models\Pickingline::find()->where(['picking_id'=>0])->all();
//        }

//return;


        if ($model->load(Yii::$app->request->post())) {
            $prodid = Yii::$app->request->post('productid');
            $lineqty = Yii::$app->request->post('qty');
            $lineprice = Yii::$app->request->post('price');
            $removelist = Yii::$app->request->post('removelist');

            if($model->save()){
                if(count($prodid)>0){
                    for($i=0;$i<=count($prodid)-1;$i++){
                        if($prodid[$i]==''){continue;}

                        $modelcheck = \backend\models\Saleline::find()->where(['sale_id'=>$id,'product_id'=>$prodid[$i]])->one();
                        if($modelcheck){
                            $modelcheck->qty = $lineqty[$i];
                            $modelcheck->price = $lineprice[$i];
                            $modelcheck->line_amount = $lineqty[$i] * $lineprice[$i];
                            $modelcheck->save();
                        }else{
                            $modelline = new \backend\models\Saleline();
                            $modelline->sale_id = $model->id;
                            $modelline->product_id = $prodid[$i];
                            $modelline->qty = $lineqty[$i];
                            $modelline->price = $lineprice[$i];
                            $modelline->line_amount = $lineqty[$i] * $lineprice[$i];
                            $modelline->save();
                        }
                    }
                }
                if(count($removelist)){
                    \backend\models\Quotationline::deleteAll(['id'=>$removelist]);
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelline' => $modelline,
            'modelpick' => $modelpick
        ]);
    }

    /**
     * Deletes an existing Sale model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        \backend\models\Saleline::deleteAll(['sale_id'=>$id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sale model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sale the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sale::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreateinvoice(){
        if(Yii::$app->request->isPost){
            $id = Yii::$app->request->post('sale_id');
            if($id){
                $model = \backend\models\Sale::find()->where(['id'=>$id])->one();
                $modelline = \backend\models\Saleline::find()->where(['sale_id'=>$id])->all();

                if($model){
                    $order = new \backend\models\Invoice();
                    $order->sale_id = $model->id;
                    $order->invoice_no = "INV0001";
                    $order->status = 1;
                    $order->note = $model->note;
                    if($order->save()){
                        if(count($modelline)>0){
                            foreach($modelline as $value){
                                $orderline = new \backend\models\Invoiceline();
                                $orderline->invoice_id = $order->id;
                                $orderline->product_id = $value->product_id;
                                $orderline->qty = $value->qty;
                                $orderline->price = $value->price;
                                $orderline->disc_amount = $value->disc_amount;
                                $orderline->line_amount = $value->line_amount;
                                $orderline->save();
                            }
                        }
                    }
                }
            }
        }
        return $this->redirect(['invoice/index']);
    }
}
