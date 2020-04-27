<?php

namespace backend\controllers;

use backend\models\Productstock;
use Yii;
use backend\models\Inboundinv;
use backend\models\InboundinvSearch;
use yii\base\Request;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\web\UploadedFile;

/**
 * InboundinvController implements the CRUD actions for Inboundinv model.
 */
class InboundinvController extends Controller
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
                    'delete' => ['POST', 'GET'],
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

        if ($model->load(Yii::$app->request->post())) {
            $prodid = Yii::$app->request->post('productid');
            $lineqty = Yii::$app->request->post('qty');
            $lineprice = Yii::$app->request->post('price');
            $stockid = Yii::$app->request->post('stock_id');

            $x_date = explode('/', $model->invoice_date);
            $inv_date = date('Y-m-d');
            if (count($x_date)) {
                $inv_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }

            $cur = 1;
            if($model->currency_id == '' || $model->currency_id == null){
                $cur = 1;
            }else{
                $cur = $model->currency_id;
            }

            //echo $cur;return;

            $model->invoice_date = date('Y-m-d', strtotime($inv_date));
            $model->status = 1;
            $model->currency_id = $cur;
            if ($model->save(false)) {
                if (count($prodid) > 0) {
                    for ($i = 0; $i <= count($prodid) - 1; $i++) {
                        if ($prodid[$i] == '') {
                            continue;
                        }
                        $modelline = new \backend\models\Inboundinvline();
                        $modelline->invoice_id = $model->id;
                        $modelline->product_id = $prodid[$i];
                        $modelline->line_qty = $lineqty[$i];
                        $modelline->line_price = $lineprice[$i];
                        $modelline->kno_no_in = \backend\models\Plant::findKnoNo();
                        $modelline->kno_in_date = \backend\models\Plant::findKnoDate();
                        $modelline->line_num = $i + 1;
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

    public function updateTotalAmount($id){
        $total = \backend\models\Inboundinvline::find()->where(['invoice_id'=>$id])->sum('line_qty * line_price');
        if($total > 0){
            $model = \backend\models\Inboundinv::find()->where(['id'=>$id])->one();
            if($model){
                $model->total_amount = $total;
                $model->save(false);
            }
        }
    }
    public function actionCreatetrans($id)
    {
        if ($id) {
            $model = \backend\models\Inboundinvline::find()->where(['invoice_id' => $id])->all();

            \backend\models\Importline::deleteAll(['import_id' => $id]);

            if ($model) {
                foreach ($model as $value) {
                    $prodinfo = \backend\models\Product::findProductinfo($value->product_id);
                    $modelimport = new \backend\models\Importline();
                    $modelimport->import_id = $value->invoice_id;
                    $modelimport->product_id = $value->product_id;
                    $modelimport->qty = $value->line_qty;
                    $modelimport->price_per = $value->line_price;
                    $modelimport->price_pack1 = $prodinfo->price_carton_usd;
                    $modelimport->price_pack2 = $prodinfo->price_carton_thb;
                    $modelimport->total_price = ($value->line_price * $value->line_qty);
                    $modelimport->total_qty = $value->line_qty;
                    $modelimport->line_num = $value->line_num;
                    $modelimport->origin = $prodinfo->origin;
                    $modelimport->position = \backend\models\Product::findGeo($value->product_id);
                    $modelimport->netweight = $prodinfo->netweight;;
                    $modelimport->grossweight = $prodinfo->grossweight;
                    $modelimport->excise_no = $prodinfo->excise_no;
//                    $modelimport->kno_no_in = \backend\models\Plant::findKnoNo();
//                    $modelimport->kno_in_date = \backend\models\Plant::findKnoDate();
                    $modelimport->save(false);
                }
            }
        }
        return $this->redirect(['index']);
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
        $modelline = \backend\models\Inboundinvline::find()->where(['invoice_id' => $id])->all();
        $modeldoc = \backend\models\Importfile::find()->where(['import_id'=>$id])->all();
        if ($model->load(Yii::$app->request->post())) {
            $prodid = Yii::$app->request->post('productid');
            $lineqty = Yii::$app->request->post('qty');
            $lineprice = Yii::$app->request->post('price');
            $stockid = Yii::$app->request->post('stock_id');
            $x_date = explode('/', $model->invoice_date);
            $inv_date = date('Y-m-d');
            if (count($x_date)) {
                $inv_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }

            $model->invoice_date = date('Y-m-d', strtotime($inv_date));
            $model->status = 1;
            if ($model->save(false)) {
                if (count($prodid) > 0) {
                    \backend\models\Inboundinvline::deleteAll(['invoice_id' => $model->id]);
                    for ($i = 0; $i <= count($prodid) - 1; $i++) {
                        if ($prodid[$i] == '') {
                            continue;
                        }
                        $modelline = new \backend\models\Inboundinvline();
                        $modelline->invoice_id = $model->id;
                        $modelline->product_id = $prodid[$i];
                        $modelline->line_qty = $lineqty[$i];
                        $modelline->line_price = $lineprice[$i];
                        $modelline->kno_no_in = \backend\models\Plant::findKnoNo();
                        $modelline->kno_in_date = \backend\models\Plant::findKnoDate();
                        $modelline->line_num = $i + 1;
                        // $modelline->stock_id = $stockid[$i];
                        $modelline->save();
                    }
                }
                return $this->redirect(['index']);
            }

        }

        return $this->render('update', [
            'model' => $model,
            'modelline' => $modelline,
            'modeldoc' => $modeldoc,
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
        \backend\models\Inboundinvline::deleteAll(['invoice_id' => $id]);
        $this->recalStock($id);
        \backend\models\Productstock::deleteAll(['inbound_id'=>$id]);
        \backend\models\Importline::deleteAll(['import_id' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function recalStock($id){
            $product_stock = \backend\models\Productstock::find()->where(['inbound_id'=>$id])->all();
            foreach ($product_stock as $value){
                //$sum_all = Productstock::find()->where(['product_id'=>$value->product_id])->sum('qty');
                $in_qty =$value->in_qty;
                $model_product = \backend\models\Product::find()->where(['id'=>$value->product_id])->one();
                if($model_product){
                    $model_product->all_qty = $model_product->all_qty - $in_qty ;
                    $model_product->available_qty = $model_product->available_qty - $in_qty;
                    //    $model_product->available_qty = $model_product->all_qty - (int)$model_product->reserved_qty;
                    $model_product->save(false);
                }
            }


    }
    public function actionInboundtrans($id)
    {
        if ($id) {
            //echo $id;return;
            $modelinv = \backend\models\Inboundinv::find()->where(['id' => $id])->one();
            // $model = \backend\models\Importline::find()->where(['import_id'=>$id])->orderBy(['line_num'=>SORT_ASC])->all();
            $model = \backend\models\Inboundinvline::find()->where(['invoice_id' => $id])->orderBy(['line_num' => SORT_ASC])->all();
            return $this->render('_inboundtrans', [
                'model' => $model,
                'invoice_no' => $id,
                'modelinv' => $modelinv
            ]);
        }
    }
    public function actionAttachfile(){
        $invoiceid = Yii::$app->request->post('inv_id');
        $doc_file = UploadedFile::getInstanceByName('doc_file');
        if(!empty($doc_file)){
            $doc_name = time().".".$doc_file->getExtension();
            $doc_file->saveAs(Yii::getAlias('@backend') .'/web/uploads/doc_in/'.$doc_name);
            $model = new \backend\models\Importfile();
            $model->import_id = $invoiceid;
            $model->filename = $doc_name;
            $model->save(false);
            return $this->redirect(['inboundinv/update','id'=>$invoiceid]);
        }else{
            echo 'no file';
        }
    }
    public function actionDeletedoc(){
        $recid = Yii::$app->request->post('recid');
        if($recid){
            $model = \backend\models\Importfile::find()->where(['id'=>$recid])->one();
            if($model){
                unlink(Yii::getAlias('@backend') .'/web/uploads/doc_in/'.$model->filename);
                \backend\models\Importfile::deleteAll(['id'=>$recid]);
                return true;
            }
        }
        return false;
    }
    public function actionRecieve()
    {
        $currencyid = Yii::$app->request->post('currency_id');
        $productid = Yii::$app->request->post('product_id');
        $invoiceid = Yii::$app->request->post('invoice_id');
        $invoiceno = Yii::$app->request->post('invoice_no');
        $invoicedate = Yii::$app->request->post('invoice_date');
        $refid = Yii::$app->request->post('recid');
        $pack1 = Yii::$app->request->post('product_pack1');
        $pack2 = Yii::$app->request->post('product_pack2');
        $lineqty = Yii::$app->request->post('line_qty');
        $linepacking = Yii::$app->request->post('line_packing');
        $linepriceper = Yii::$app->request->post('line_price_per2');
        $linetotalamount = Yii::$app->request->post('line_total_amount');
        $linetransportno = Yii::$app->request->post('line_transport_in_no');
        $linetransportdate = Yii::$app->request->post('line_transport_in_date');
        $linenum = Yii::$app->request->post('line_num');
        $linepermitno = Yii::$app->request->post('line_permit_no');
        $linepermitdate = Yii::$app->request->post('line_permit_date');
        $lineexciseno = Yii::$app->request->post('line_excise_no');
        $lineexcisedate = Yii::$app->request->post('line_excise_date');
        $linekno_no = Yii::$app->request->post('line_kno_no');
        $linekno_date = Yii::$app->request->post('line_kno_date');

        //return;

        $permit_date = null;
        $transport_date = null;
        $inv_date = null;
        $trans_date = null;
        $kno_date = null;

        $inv_month = 0;

//        $trans_origin = explode('/',$rowData[14]);
//        if(count($trans_origin)>0 && $trans_origin[0] !=''){
//            $trans_date = $trans_origin[2]."/".$trans_origin[1]."/".$trans_origin[0];
//        }
//
        $inv_date_x = explode('-',$invoicedate);
        if(count($inv_date_x)>0 && $inv_date_x[0] !=''){
            $inv_date = $inv_date_x[2]."/".$inv_date_x[1]."/".$inv_date_x[0];
            $inv_month = $inv_date_x[1];
        }
//
//        $kno_origin = explode('/',$rowData[19]);
//        if(count($kno_origin)>0 && $kno_origin[0] !=''){
//            $kno_date = $kno_origin[2]."/".$kno_origin[1]."/".$kno_origin[0];
//        }


        if (count($productid) > 0) {
            $data = [];
            for ($i = 0; $i <= count($productid) - 1; $i++) {
                $model = \backend\models\Inboundinvline::find()->where(['invoice_id' => $invoiceid, 'product_id' => $productid[$i],'line_num'=>$linenum[$i]])->one();

                if ($linepermitdate[$i] != '') {
                    //  echo  $linepermitdate[$i];return;
                    $per_origin = explode('-', $linepermitdate[$i]);
                    if (count($per_origin) > 0 && $per_origin[0] != '') {
                        $permit_date = $per_origin[2] . "/" . $per_origin[1] . "/" . $per_origin[0];
                    }
                }
               // echo $permit_date;return;
                if ($linetransportdate[$i] != '') {
                    //  echo  $linepermitdate[$i];return;
                    $trans_date = explode('-', $linetransportdate[$i]);
                    if (count($trans_date) > 0 && $trans_date[0] != '') {
                        $transport_date = $trans_date[2] . "/" . $trans_date[1] . "/" . $trans_date[0];
                    }
                }
                if ($linekno_date[$i] != '') {
                    //  echo  $linepermitdate[$i];return;
                    $kno_date_arr = explode('/', $linekno_date[$i]);
                    //print_r($kno_date_arr[0]);return;
                    if (count($kno_date_arr) > 0 && $kno_date_arr[0] != '') {
                        $kno_date = $kno_date_arr[2] . "/" . $kno_date_arr[1] . "/" . $kno_date_arr[0];
                    }
                }
                //echo $inv_date.' '.$kno_date.' '.$permit_date;return;

                if ($model) {
                    $model->permit_no = $linepermitno[$i];
                    $model->permit_date = date('Y-m-d', strtotime($linepermitdate[$i]));
                    $model->transport_in_no = $linetransportno[$i];
                    $model->transport_in_date = date('Y-m-d',strtotime($transport_date));
                    $model->kno_in_date = date('Y-m-d',strtotime($kno_date));
                   // $model->unit_id = \backend\models\Product::findUnit($model->product_id);

                    if ($model->save(false)) {
                       $model_master = \backend\models\Inboundinv::find()->where(['id'=>$model->invoice_id])->one();
                       if($model_master){
                           $model_master->status = 2;
                           $model_master->save(false);
                       }
                    }

                }

                //$catid = $this->checkCat($rowData[6]);
                $whid = \backend\models\Warehouse::getDefault();

                $ex_rate = 1;
                $ex_rate = \backend\models\Currencyrate::findRateMonth($currencyid,$inv_month,1);


//                $usd = str_replace(",","",$linepriceper[$i]);
//                $thb = str_replace(",","",$linepriceper[$i]);

                $usd = str_replace(",","",$pack1[$i]);
                $thb = str_replace(",","",$pack2[$i]);
                array_push($data, [
                    'prod_id' => $productid[$i],
                    'qty' => $lineqty[$i],
                    'warehouse_id' => $whid,
                    'trans_type' => \backend\helpers\TransType::TRANS_ADJUST_IN,
                    'permit_no' => $linepermitno[$i],
                    'permit_date' =>$linepermitdate[$i],// date('Y-m-d',strtotime($permit_date)),// $permit_date,//date('Y-d-m',strtotime($linepermitdate[$i])),
                    'transport_in_no' => $linetransportno[$i],
                    'transport_in_date' => $linetransportdate[$i],//date('Y-d-m',strtotime($rowData[14])),
                    'excise_no' => $lineexciseno[$i],
                    'excise_date' => date('Y-d-m', strtotime($lineexcisedate[$i])),
                    'invoice_no' => $invoiceno,
                    'invoice_date' => $inv_date,//date('Y-d-m', strtotime($invoicedate)),//date('Y-d-m',strtotime($rowData[12])),
                    'sequence' => $linenum[$i],
                    'kno_no_in' => $linekno_no[$i],
                    'kno_in_date' => $kno_date,//date('Y-d-m',strtotime($rowData[19])),
                    'out_qty' => 0,
                    'usd_rate' => $usd,
                    'thb_amount' => $thb,
                    'inbound_id' => $model->invoice_id,
                    'outbound_id' => 0

                ]);


            }

           // print_r($data);return;

            $update_stock = \backend\models\TransCalculate::createJournal($data);
            if ($update_stock) {
                $session = Yii::$app->session;
                $session->setFlash('msg', 'นำเข้าข้อมูลสินค้าเรียบร้อย');
                return $this->redirect(['index']);
            } else {
                echo 'no';return;
                $session = Yii::$app->session;
                $session->setFlash('msg-error', 'พบข้อมผิดพลาด');
                return $this->redirect(['index']);
            }


        }
    }

    protected function findModel($id)
    {
        if (($model = Inboundinv::findOne($id)) !== null) {
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
        }else {

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
//                    ->where(['>','all_qty',0])
//                    ->andFilterWhere(['!=','stock_id',''])
                    ->asArray()
                    ->all();
                return Json::encode($model);
                //   }
            }else{
                $model = \common\models\QueryProduct::find()->where(['or',['Like','product_code',$txt],['Like','name',$txt]])
                    ->orFilterWhere(['like','product_code',$txt])
                    ->orFilterWhere(['like','name',$txt])
//                    ->andFilterWhere(['>','all_qty',0])
//                    ->andFilterWhere(['!=','stock_id',''])
                    ->asArray()
                    ->all();
                return Json::encode($model);
            }


        }

    }
    public function actionCheckRate(){
        $id = \Yii::$app->request->post('cur_id');
        $m = \Yii::$app->request->post('month');
        // echo (int)$m;return;
        $data = [];
        $rate_name = \backend\models\Currency::findName($id);

        if($rate_name == 'THB'){
           // echo $rate_name;return;
            array_push($data,['exp_date'=>'1970/01/01','exc_rate'=>1,'currency'=>$rate_name]);
            echo Json::encode($data);return;
        }
        if($id){
            $model = \backend\models\Currencyrate::findRateMonth($id,$m,1);
            if($model){
                $final_date = '';
                $xdate = explode('-',$model->to_date);
                if(count($xdate)>0){
                    $final_date = $xdate[0].'/'.$xdate[1].'/'.$xdate[2];
                }
                array_push($data,['exp_date'=>$final_date,'exc_rate'=>$model->rate,'currency'=>'']);
            }else{
                array_push($data,['exp_date'=>'1970/01/01','exc_rate'=>1,'currency'=>'']);
            }
        }
        echo Json::encode($data);
    }
    public function actionPayment()
    {
        $inboundid = \Yii::$app->request->post('saleid');
        $pdate = \Yii::$app->request->post('payment_date');
        $ptime = \Yii::$app->request->post('payment_time');
        $pamount = \Yii::$app->request->post('amount');
        $note = \Yii::$app->request->post('note');
        $uploaded = UploadedFile::getInstanceByName('payment_slip');
        $file = '';
        if ($uploaded) {
            $file = $uploaded->name;
            $uploaded->saveAs(Yii::getAlias('@backend') . '/web/uploads/slip/' . $uploaded->name);
        }


        if ($pdate != '') {
            if ($pamount != '' && $pamount > 0) {
                $model = new \backend\models\Inboundpayment();
                $model->inbound_id = $inboundid;
                $model->trans_date = date('Y-m-d', strtotime($pdate));
                $model->trans_time = date('H:i:s', strtotime($ptime));
                $model->amount = $pamount;
                $model->note = $note;
                $model->status = 1;
                $model->slip = $file;

                if ($model->save()) {
                    self::updatePayment($inboundid, $model->amount);
                }
            }
        }else{
           // echo "no";return;
        }

        return $this->redirect(['index']);
    }
    public function updatePayment($inboundid, $payamount)
    {
        if ($inboundid) {
            $model = \backend\models\Inboundinv::find()->where(['id' => $inboundid])->one();
            if ($model) {
                $model_paytrans = \backend\models\Inboundpayment::find()->where(['inbound_id' => $inboundid])->sum('amount');

                if ($model->total_amount <= ($payamount + $model_paytrans)) {
                    $model->payment_status = 1;
                    if ($model->save(false)) {
                        $closeinv = \backend\models\Inboundinv::find()->where(['id' => $inboundid])->one();
                        if ($closeinv) {
                            $closeinv->status = 2;
                            $closeinv->save(false);
                        }
                    }
                }
            }
        }
    }
    public function actionPrint($id)
    {
        // echo $id;return;
        $model = \backend\models\Inboundinv::find()->where(['id' => $id])->one();
        $modelline = \backend\models\Inboundinvline::find()->where(['invoice_id' => $id])->all();

        if ($model) {
            // return "nira";
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                //  'format' => [150,236], //manaul
                'format' => Pdf::FORMAT_A4,
                //'format' =>  Pdf::FORMAT_A5,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('_print', [
                    'model' => $model,
                    'modelline' => $modelline,

                ]),
                //'content' => "nira",
                // 'defaultFont' => '@backend/web/fonts/config.php',
                'cssFile' => '@backend/web/css/pdf.css',
                'options' => [
                    'title' => 'PACKING LIST',
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

//            $defaultConfig = (new ConfigVariables())->getDefaults();
//            $fontDirs = $defaultConfig['fontDir'];
//
//            $defaultFontConfig = (new FontVariables())->getDefaults();
//            $fontData = $defaultFontConfig['fontdata'];


//            $pdf->options['fontDir'] = array_merge($fontDirs, [
//               // Yii::getAlias('@backend').'/web/fonts'
//                Yii::$app->basePath
//            ]);

//            $pdf->options = array_merge($pdf->options , [
//                'fontDir' => array_merge($fontDirs, [ Yii::$app->basePath . '/web/fonts']),  // make sure you refer the right physical path
//                'fontdata' => array_merge($fontData, [
//                    'angsana' => [
//                        'R' => 'angsa.ttf',
////                        'I' => 'THSarabunNew Italic.ttf',
////                        'B' => 'THSarabunNew Bold.ttf',
//                    ]
//                ])
//            ]);
            //return $this->redirect(['genbill']);
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            Yii::$app->response->headers->add('Content-Type', 'application/pdf');
            return $pdf->render();
        }
    }

    public function actionPrintinv($id)
    {
        // echo $id;return;
        $model = \backend\models\Inboundinv::find()->where(['id' => $id])->one();
        $modelline = \backend\models\Inboundinvline::find()->where(['invoice_id' => $id])->all();

        if ($model) {
            // return "nira";
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                //  'format' => [150,236], //manaul
                'format' => Pdf::FORMAT_A4,
                //'format' =>  Pdf::FORMAT_A5,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('_printinv', [
                    'model' => $model,
                    'modelline' => $modelline,

                ]),
                //'content' => "nira",
                // 'defaultFont' => '@backend/web/fonts/config.php',
                'cssFile' => '@backend/web/css/pdf.css',
                'options' => [
                    'title' => 'INVOICE',
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

            //return $this->redirect(['genbill']);
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            Yii::$app->response->headers->add('Content-Type', 'application/pdf');
            return $pdf->render();
        }
    }
    public function actionShowdoc(){
        $doc_no = \Yii::$app->request->post('doc_no');
        $invoice_no = \Yii::$app->request->post('invoice_no');
        $invoice_id = \Yii::$app->request->post('invoice_id');
        $res = [];
        $html = '';
        $docfile = '';
        if($doc_no != ''){
            $model = \backend\models\Productstock::find()->where(['transport_in_no'=> trim($doc_no)])->all();
            if($model){
                foreach ($model as $value){
                    $html.='<tr>';
                    $html.='<td>'.\backend\models\Product::findCode($value->product_id).'</td>';
                    $html.='<td>'.\backend\models\Product::findName($value->product_id).'</td>';
                    $html.='<td>'.\backend\models\Product::findNameThai($value->product_id).'</td>';
                    $html.='<td>'.number_format($value->in_qty).'</td>';
                    $html.='</tr>';
                }
            }
            $res[1] = $html;
        }else{
            $res[1] = $html;
        }
        if($invoice_id != ''){
            $model = \backend\models\Importfile::find()->where(['import_id'=> $invoice_id])->one();
            if($model){
                $res[0] = '<a class="btn btn-success" target="_blank" href="../web/uploads/doc_in/'.$model->filename.'">'.$model->filename.'</a>';
            }else{
                $res[0] = '';
            }
        }else{
            $res[0] = '';
        }

        return Json::encode($res);
    }

    public function actionSavedoc(){
        //$doc_no = \Yii::$app->request->post('doc_no');
        $invoiceid = Yii::$app->request->post('invoice_id');
        $invoice_no = Yii::$app->request->post('invoice_no');
        $doc_file = UploadedFile::getInstanceByName('doc_file');


        //echo $invoiceid;return;

        if(!empty($doc_file) && $invoiceid !=''){
          //  echo 'ok';return;
            $doc_name = time().".".$doc_file->getExtension();
            $doc_file->saveAs(Yii::getAlias('@backend') .'/web/uploads/doc_in/'.$doc_name);
            $model = new \backend\models\Importfile();
            $model->import_id = $invoiceid;
            $model->filename = $doc_name;
            $model->save(false);
            return $this->redirect(['inboundinv/view','id'=>$invoiceid]);
        }else{
            echo 'no file';
        }
    }
}
