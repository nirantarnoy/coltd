<?php

namespace backend\controllers;

use Yii;
use backend\models\Quotation;
use backend\models\QuotationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends Controller
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
     * Lists all Quotation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new QuotationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Quotation model.
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
     * Creates a new Quotation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Quotation();

        if ($model->load(Yii::$app->request->post())) {
            $prodid = Yii::$app->request->post('productid');
            $lineqty = Yii::$app->request->post('qty');
            $lineprice = Yii::$app->request->post('price');
            $stockid = Yii::$app->request->post('stock_id');

            $tdate = explode('/',$model->require_date);
            $t_date = $tdate[2].'/'.$tdate[1].'/'.$tdate[0];

            $model->require_date = strtotime($t_date);
            $model->status = 1;
            if($model->save()){
                if(count($prodid)>0){
                    for($i=0;$i<=count($prodid)-1;$i++){
                        if($prodid[$i]==''){continue;}
                        $modelline = new \backend\models\Quotationline();
                        $modelline->quotation_id = $model->id;
                        $modelline->product_id = $prodid[$i];
                        $modelline->qty = $lineqty[$i];
                        $modelline->price = $lineprice[$i];
                        $modelline->stock_id = $stockid[$i];
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

    /**
     * Updates an existing Quotation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelline = \backend\models\Quotationline::find()->where(['quotation_id'=>$id])->all();
        if ($model->load(Yii::$app->request->post())) {
            $prodid = Yii::$app->request->post('productid');
            $lineqty = Yii::$app->request->post('qty');
            $lineprice = Yii::$app->request->post('price');
            $stockid = Yii::$app->request->post('stock_id');
            $removelist = Yii::$app->request->post('removelist');

            //print_r($removelist);return;
            $tdate = explode('/',$model->require_date);
            $t_date = $tdate[2].'/'.$tdate[1].'/'.$tdate[0];

            //print $t_date.'<br />';
            //print strtotime(date('Y-m-d',$t_date)).'<br />';
//            print strtotime(date('d-m-Y')).'<br />';
//            print date('Y-m-d',strtotime($t_date));return;

            $model->require_date = strtotime($t_date);
            $model->status = 1;
            if($model->save()){
                if(count($prodid)>0){
                    for($i=0;$i<=count($prodid)-1;$i++){
                        if($prodid[$i]==''){continue;}

                        $modelcheck = \backend\models\Quotationline::find()->where(['quotation_id'=>$id,'product_id'=>$prodid[$i]])->one();
                        if($modelcheck){
                            $modelcheck->qty = $lineqty[$i];
                            $modelcheck->price = $lineprice[$i];
                            $modelcheck->line_amount = $lineqty[$i] * $lineprice[$i];
                            $modelcheck->stock_id = $stockid;
                            $modelcheck->save();
                        }else{
                            $modelline = new \backend\models\Quotationline();
                            $modelline->quotation_id = $model->id;
                            $modelline->product_id = $prodid[$i];
                            $modelline->qty = $lineqty[$i];
                            $modelline->price = $lineprice[$i];
                            $modelline->stock_id = $stockid[$i];
                            $modelline->line_amount = $lineqty[$i] * $lineprice[$i];
                            $modelline->save();
                        }
                    }
                }
                if(count($removelist)){
                    print_r($removelist);return;
                    \backend\models\Quotationline::deleteAll(['id'=>$removelist]);
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelline' => $modelline,
        ]);
    }

    /**
     * Deletes an existing Quotation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        \backend\models\Quotationline::deleteAll(['quotation_id'=>$id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Quotation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quotation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quotation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionFinditem(){
        $txt = \Yii::$app->request->post('txt');
        $list = [];
        if($txt == ''){
            return Json::encode($list);
            //return 'no';
        }else{

//            if($txt == "*"){
//                $model = \backend\models\Product::find()
//                    ->asArray()
//                    ->all();
//                return Json::encode($model);
//            }else{
//                $model = \backend\models\Product::find()->where(['or',['Like','engname',$txt],['Like','name',$txt]])
//                    ->orFilterWhere(['like','engname',$txt])
//                    ->orFilterWhere(['like','name',$txt])
//                    ->asArray()
//                    ->all();
//                return Json::encode($mode`l);
//            }
            if($txt == "*"){
                $model = \common\models\QueryProduct::find()
                    ->asArray()
                    ->all();
                return Json::encode($model);
            }else{
                $model = \common\models\QueryProduct::find()->where(['or',['Like','product_code',$txt],['Like','name',$txt]])
                    ->orFilterWhere(['like','product_code',$txt])
                    ->orFilterWhere(['like','name',$txt])
                    ->asArray()
                    ->all();
                return Json::encode($model);
            }


        }

    }
    public function actionFirmorder(){
        if(Yii::$app->request->isPost){
            $id = Yii::$app->request->post('quotation_id');
            if($id){
                $model = \backend\models\Quotation::find()->where(['id'=>$id])->one();
                $modelline = \backend\models\Quotationline::find()->where(['quotation_id'=>$id])->all();

                if($model){
                    $order = new \backend\models\Sale();
                    $order->sale_no = \backend\models\Sale::getLastNo();
                    $order->customer_id = $model->customer_id;
                    $order->quotation_id = $model->id;
                    $order->status = 1;
                    $order->require_date = $model->require_date;
                    $order->currency = $model->currency;
                    $order->note = $model->note;
                    $order->delvery_to = $model->delvery_to;
                    $order->payment_status = 0;
                    $order->total_amount = self::calTotal($modelline);
                    if($order->save()){
                        if(count($modelline)>0){
                            foreach($modelline as $value){
                                $orderline = new \backend\models\Saleline();
                                $orderline->sale_id = $order->id;
                                $orderline->product_id = $value->product_id;
                                $orderline->qty = $value->qty;
                                $orderline->price = $value->price;
                                $orderline->disc_amount = $value->disc_amount;
                                $orderline->line_amount = $value->line_amount;
                                $orderline->stock_id = $value->stock_id;
                                $orderline->save();
                            }
                        }
                    }
                }
            }
        }
        return $this->redirect(['sale/index']);
    }
    public function calTotal($modelline){
        $totalamt = 0;
        if(count($modelline)>0){
            foreach($modelline as $value){
                $totalamt = $totalamt + ($value->qty * $value->price);
            }
        }
        return $totalamt;
    }
    public function actionBill($id){
        $model = \backend\models\Quotation::find()->where(['id' => $id])->one();
        $modelline = \backend\models\Quotationline::find()->where(['quotation_id'=>$id])->all();

        if($model){
            // return "nira";
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                //  'format' => [150,236], //manaul
                'format' =>  Pdf::FORMAT_A4,
                //'format' =>  Pdf::FORMAT_A5,
                'orientation' =>Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('_quotation',[
                    'model'=>$model,
                    'modelline'=>$modelline,

                ]),
                //'content' => "nira",
                // 'defaultFont' => '@backend/web/fonts/config.php',
                'cssFile' => '@backend/web/css/pdf.css',
                'options' => [
                    'title' => 'QUATATION',
                    'subject' => ''
                ],
                'methods' => [
                    //  'SetHeader' => ['รายงานรหัสสินค้า||Generated On: ' . date("r")],
                    //  'SetFooter' => ['|Page {PAGENO}|'],
                    //'SetFooter'=>'niran',
                ],
                'marginLeft' => 5,
                'marginRight' => 5,
                'marginTop' => 10,
                'marginBottom' => 10,
                'marginFooter' => 5

            ]);

            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];


//            $pdf->options['fontDir'] = array_merge($fontDirs, [
//               // Yii::getAlias('@backend').'/web/fonts'
//                Yii::$app->basePath
//            ]);

            $pdf->options = array_merge($pdf->options , [
                'fontDir' => array_merge($fontDirs, [ Yii::$app->basePath . '/web/fonts']),  // make sure you refer the right physical path
                'fontdata' => array_merge($fontData, [
                    'angsana' => [
                        'R' => 'angsa.ttf',
//                        'I' => 'THSarabunNew Italic.ttf',
//                        'B' => 'THSarabunNew Bold.ttf',
                    ]
                ])
            ]);
            //return $this->redirect(['genbill']);
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            Yii::$app->response->headers->add('Content-Type', 'application/pdf');
            return $pdf->render();
        }
    }
    public function actionCheckRate(){
        $id = \Yii::$app->request->post('cur_id');
       // echo $id;return;
        $data = [];
        if($id){
            $model = \backend\models\Currencyrate::findRate($id);
            if($model){
                $final_date = '';
                $xdate = explode('-',$model->to_date);
                if(count($xdate)>0){
                    $final_date = $xdate[2].'/'.$xdate[1].'/'.$xdate[0];
                }
              array_push($data,['exp_date'=>$final_date,'exc_rate'=>$model->rate]);
            }
        }
        echo Json::encode($data);
    }
}
