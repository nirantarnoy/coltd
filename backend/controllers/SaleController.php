<?php

namespace backend\controllers;

use backend\models\PickinglineSearch;
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
class SaleController extends Controller
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


        $modelpick = \backend\models\Picking::find()->where(['sale_id'=>$id])->all();
        if($modelpick){
            foreach ($modelpick as $value){
                array_push($pickinglist,$value->id);
            }
        }
        $modelpickline = \backend\models\Pickingline::find()->where(['picking_id'=>$pickinglist])->all();
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
            'modelpick' => $modelpick,
            'modelpickline' => $modelpickline
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
                $model = \backend\models\Picking::find()->where(['id'=>$id])->one();
                $modelline = \backend\models\Pickingline::find()->where(['picking_id'=>$id])->all();

                if($model){
                    $order = new \backend\models\Invoice();
                    $order->sale_id = $model->id;
                    $order->invoice_no = $order::getLastNo();
                    $order->status = 1;
                    $order->picking_id = $id;
                    $order->note = $model->note;
                    if($order->save()){
                        if(count($modelline)>0){
                            foreach($modelline as $value){
                                $orderline = new \backend\models\Invoiceline();
                                $orderline->invoice_id = $order->id;
                                $orderline->product_id = $value->product_id;
                                $orderline->qty = $value->qty;
                                $orderline->price = $value->price;
                              //  $orderline->disc_amount = $value->disc_amount;
                              //  $orderline->line_amount = $value->line_amount;
                                $orderline->save();
                            }
                        }
                    }
                }
            }
        }
        return $this->redirect(['invoice/index']);
    }
    public function actionFindwarehouse(){
        $prod = \Yii::$app->request->post("prod");
        if($prod !=''){
            $model = \backend\models\Warehouse::find()->all();
            if($model){
                foreach($model as $val){
                    echo "<option value='" . $val->id . "'>$val->name</option>";
                }
            }
        }else{
            echo "";
        }
    }
    public function actionFindpermit(){
        $prod = \Yii::$app->request->post("prod");
        if($prod !=''){
            $model = \backend\models\Stockbalance::find()->where(['product_id'=>$prod])->andFilterWhere(['!=','qty',0])->all();
            if($model){
                foreach($model as $val){
                    echo "<option value='" . $val->id . "'>$val->permit_no</option>";
                }
            }
        }else{
            echo "";
        }
    }
    public function actionFindtransport(){
        $prod = \Yii::$app->request->post("prod");
        if($prod !=''){
            $model = \backend\models\Stockbalance::find()->where(['product_id'=>$prod])->andFilterWhere(['!=','qty',0])->all();
            if($model){
                foreach($model as $val){
                    echo "<option value='" . $val->id . "'>$val->transport_in_no</option>";
                }
            }
        }else{
            echo "";
        }
    }
    public function actionCreatepicking(){
        $sale = \Yii::$app->request->post("sale_id");
        if($sale){
            $prod = \Yii::$app->request->post("product_id");
            $qty = \Yii::$app->request->post("line_qty");
            $price = \Yii::$app->request->post("line_price");
            $warehouse = \Yii::$app->request->post("picking_wh");
            $permit = \Yii::$app->request->post("picking_permit");
            $transport = \Yii::$app->request->post("picking_transport");


            $model = new \backend\models\Picking();
            $model->picking_no = $model::getLastNo();
            $model->sale_id = $sale;
            $model->trans_date = strtotime(date('d/m/Y'));
            $model->status= 1;
            if($model->save(false)){
                if(count($prod)>0){
                    for($i=0;$i<=count($prod)-1;$i++){
                        $modelline = new \backend\models\Pickingline();
                        $modelline->picking_id = $model->id;
                        $modelline->product_id = $prod[$i];
                        $modelline->qty = (int)$qty[$i];
                        $modelline->price = (float)$price[$i];
                        $modelline->warehouse_id = $warehouse[$i];
                        $modelline->permit_no = $permit[$i];
                        $modelline->transport_in_no = $transport[$i];
                        $modelline->status = 1;
                        $modelline->save();
                    }
                }

            }

            $this->updateStock($model->id);

            return $this->redirect(['update','id'=>$sale]);
        }
        return "";

    }
    public function updateStock($pickingid){
        $modelline = \backend\models\Pickingline::find()->where(['picking_id'=>$pickingid])->all();
        if($modelline){
            $data = [];
            foreach($modelline as $value){
                array_push($data,[
                    'prod_id'=>$value->product_id,
                    'qty'=>$value->qty,
                    'warehouse_id'=>$value->warehouse_id,
                    'trans_type'=>TransType::TRANS_PICKING,
                    'permit_no' => $value->permit_no,
                    'transport_no' => $value->transport_in_no,
                    'excise_no'=> $value->excise_no,
                ]);
            }
            $uptrans = TransCalculate::createJournal($data);
        }
    }
    public function actionPrintpicking(){
        if(Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('sale_id');
            if ($id) {
               $this->redirect(['bill','id'=>$id,['target'=>'_blank']]);
            }
        }
    }
    public function actionBill($id){
        $model = \backend\models\Picking::find()->where(['id' => $id])->one();
        $modelline = \backend\models\Pickingline::find()->where(['picking_id'=>$id])->all();

        if($model){
            // return "nira";
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                //  'format' => [150,236], //manaul
                'format' =>  Pdf::FORMAT_A4,
                //'format' =>  Pdf::FORMAT_A5,
                'orientation' =>Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('_picking',[
                    'model'=>$model,
                    'modelline'=>$modelline,

                ]),
                //'content' => "nira",
                // 'defaultFont' => '@backend/web/fonts/config.php',
                'cssFile' => '@backend/web/css/pdf.css',
                'options' => [
                    'title' => 'PICKING LIST',
                    'subject' => ''
                ],
                'methods' => [
                    //  'SetHeader' => ['รายงานรหัสสินค้า||Generated On: ' . date("r")],
                    //  'SetFooter' => ['|Page {PAGENO}|'],
                    //'SetFooter'=>'niran',
                ],

            ]);
            //return $this->redirect(['genbill']);
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            Yii::$app->response->headers->add('Content-Type', 'application/pdf');
            return $pdf->render();
        }
    }
}
