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
use yii\web\UploadedFile;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

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
                    'delete' => ['POST', 'GET'],
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
        //echo Yii::$app->basePath;return;
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
        $modelline = \backend\models\Saleline::find()->where(['sale_id' => $id])->all();
        $paymenttrans = \backend\models\Paymenttrans::find()->where(['sale_id' => $id])->all();

        $pickinglist = [];
        $modelpick = \backend\models\Picking::find()->where(['sale_id' => $id])->all();
        if ($modelpick) {
            foreach ($modelpick as $value) {
                array_push($pickinglist, $value->id);
            }
        }
        $modelpickline = \backend\models\Pickingline::find()->where(['picking_id' => $pickinglist])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelline' => $modelline,
            'payment' => $paymenttrans,
            'modelpick' => $modelpick,
            'modelpickline' => $modelpickline
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
            $prodid = Yii::$app->request->post('productid');
            $lineqty = Yii::$app->request->post('qty');
            $lineprice = Yii::$app->request->post('price');
            $removelist = Yii::$app->request->post('removelist');


            //echo date('m-d-Y',strtotime($model->require_date));return;
            $tdate = explode('/', $model->require_date);
            $t_date = $tdate[2] . '/' . $tdate[1] . '/' . $tdate[0];
            $model->require_date = strtotime($t_date);
            $model->status = 1;
            $model->payment_status = 0;
            if ($model->save(false)) {
                if (count($prodid) > 0) {
                    for ($i = 0; $i <= count($prodid) - 1; $i++) {
                        if ($prodid[$i] == '') {
                            continue;
                        }

                        $modelcheck = \backend\models\Saleline::find()->where(['sale_id' => $model->id, 'product_id' => $prodid[$i]])->one();
                        if ($modelcheck) {
                            $modelcheck->qty = $lineqty[$i];
                            $modelcheck->price = $lineprice[$i];
                            $modelcheck->line_amount = $lineqty[$i] * $lineprice[$i];
                            $modelcheck->save();
                        } else {
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
                if (count($removelist)) {
                    \backend\models\Quotationline::deleteAll(['id' => $removelist]);
                }
                return $this->redirect(['index']);
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
        $modelline = \backend\models\Saleline::find()->where(['sale_id' => $id])->all();
        $modelpayment = \backend\models\Paymenttrans::find()->where(['sale_id' => $id])->all();
        $modeldoc = \backend\models\Exportfile::find()->where(['sale_id' => $id])->all();

        $pickinglist = [];


        $modelpick = \backend\models\Picking::find()->where(['sale_id' => $id])->all();

        if ($modelpick) {
            foreach ($modelpick as $value) {
                array_push($pickinglist, $value->id);
            }
        }
        $modelpickline = \backend\models\Pickingline::find()->where(['picking_id' => $pickinglist])->all();
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
            $recid = Yii::$app->request->post('recid');
            $prodid = Yii::$app->request->post('productid');
            $lineqty = Yii::$app->request->post('qty');
            $lineprice = Yii::$app->request->post('price');
            $removelist = Yii::$app->request->post('removelist');

            $tdate = explode('/', $model->require_date);
            $t_date = $tdate[2] . '/' . $tdate[1] . '/' . $tdate[0];

            $model->require_date = strtotime($t_date);
            $model->status = 1;
            if ($model->save()) {
                if (count($prodid) > 0) {
                    for ($i = 0; $i <= count($prodid) - 1; $i++) {
                        if ($prodid[$i] == '') {
                            continue;
                        }

                        $modelcheck = \backend\models\Saleline::find()->where(['sale_id' => $id, 'product_id' => $prodid[$i], 'id' => $recid[$i]])->one();
                        if ($modelcheck) {
                            $modelcheck->qty = $lineqty[$i];
                            $modelcheck->price = $lineprice[$i];
                            $modelcheck->line_amount = $lineqty[$i] * $lineprice[$i];
                            $modelcheck->save();
                        } else {
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
                if (count($removelist)) {
                    \backend\models\Quotationline::deleteAll(['id' => $removelist]);
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelline' => $modelline,
            'modelpick' => $modelpick,
            'modelpickline' => $modelpickline,
            'modelpayment' => $modelpayment,
            'modeldoc' => $modeldoc

        ]);
    }

    public function actionAttachfile()
    {
        $invoiceid = Yii::$app->request->post('inv_id');
        $doc_file = UploadedFile::getInstanceByName('doc_file');
        if (!empty($doc_file)) {
            $doc_name = time() . "." . $doc_file->getExtension();
            $doc_file->saveAs(Yii::getAlias('@backend') . '/web/uploads/doc_in/' . $doc_name);
            $model = new \backend\models\Exportfile();
            $model->sale_id = $invoiceid;
            $model->filename = $doc_name;
            $model->save(false);
            return $this->redirect(['sale/update', 'id' => $invoiceid]);
        } else {
            echo 'no file';
        }
    }

    public function actionDeletedoc()
    {
        $recid = Yii::$app->request->post('recid');
        if ($recid) {
            $model = \backend\models\Exportfile::find()->where(['id' => $recid])->one();
            if ($model) {
                unlink(Yii::getAlias('@backend') . '/web/uploads/doc_in/' . $model->filename);
                \backend\models\Exportfile::deleteAll(['id' => $recid]);
                return true;
            }
        }
        return false;
    }

    public function actionDelete($id)
    {
        // echo $id;return;
        \backend\models\Saleline::deleteAll(['sale_id' => $id]);
        $this->recalStock($id);
        \backend\models\Productstock::deleteAll(['outbound_id' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function recalStock($id)
    {
        $product_stock = \backend\models\Productstock::find()->where(['outbound_id' => $id])->all();
        foreach ($product_stock as $value) {
            //$sum_all = Productstock::find()->where(['product_id'=>$value->product_id])->sum('qty');
            $out_qty = $value->out_qty;
            $model_product = \backend\models\Product::find()->where(['id' => $value->product_id])->one();
            if ($model_product) {
                $model_product->all_qty = $model_product->all_qty + $out_qty;
                $model_product->available_qty = $model_product->available_qty + $out_qty;
                //    $model_product->available_qty = $model_product->all_qty - (int)$model_product->reserved_qty;
                $model_product->save(false);
            }
        }


    }

    public function actionPayment()
    {
        $saleid = \Yii::$app->request->post('saleid');
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
                $model = new \backend\models\Paymenttrans();
                $model->sale_id = $saleid;
                $model->trans_date = date('Y-m-d', strtotime($pdate));
                $model->trans_time = date('H:i:s', strtotime($ptime));
                $model->amount = $pamount;
                $model->note = $note;
                $model->status = 1;
                $model->slip = $file;

                if ($model->save()) {
                    self::updatePayment($saleid, $model->amount);
                }
            }
        }


        return $this->redirect(['index']);
    }

    public function updatePayment($saleid, $payamount)
    {
        if ($saleid) {
            $model = \backend\models\Sale::find()->where(['id' => $saleid])->one();
            if ($model) {
                $model_paytrans = \backend\models\Paymenttrans::find()->where(['sale_id' => $saleid])->sum('amount');

                if ($model->total_amount <= ($payamount + $model_paytrans)) {
                    $model->payment_status = 1;
                    if ($model->save(false)) {
                        $closeinv = \backend\models\Sale::find()->where(['id' => $saleid])->one();
                        if ($closeinv) {
                            $closeinv->status = 2;
                            $closeinv->save(false);
                        }
                    }
                }
            }
        }
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

    public function actionCreateinvoice()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('sale_id');
            if ($id) {
                $model = \backend\models\Picking::find()->where(['id' => $id])->one();
                $modelline = \backend\models\Pickingline::find()->where(['picking_id' => $id])->all();

                if ($model) {
                    $order = new \backend\models\Invoice();
                    $order->sale_id = $model->id;
                    $order->invoice_no = $order::getLastNo();
                    $order->status = 1;
                    $order->picking_id = $id;
                    $order->note = $model->note;
                    if ($order->save()) {
                        if (count($modelline) > 0) {
                            foreach ($modelline as $value) {
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

    public function actionFindwarehouse()
    {
        $prod = \Yii::$app->request->post("prod");
        if ($prod != '') {
            $model = \backend\models\Warehouse::find()->all();
            if ($model) {
                foreach ($model as $val) {
                    echo "<option value='" . $val->id . "'>$val->name</option>";
                }
            }
        } else {
            echo "";
        }
    }

    public function actionFindpermit()
    {
        $prod = \Yii::$app->request->post("prod");
        if ($prod != '') {
            $model = \backend\models\Stockbalance::find()->where(['product_id' => $prod])->andFilterWhere(['!=', 'qty', 0])->all();
            if ($model) {
                foreach ($model as $val) {
                    echo "<option value='" . $val->id . "'>$val->permit_no</option>";
                }
            }
        } else {
            echo "";
        }
    }

    public function actionFindtransport()
    {
        $prod = \Yii::$app->request->post("prod");
        if ($prod != '') {
            $model = \backend\models\Stockbalance::find()->where(['product_id' => $prod])->andFilterWhere(['!=', 'qty', 0])->all();
            if ($model) {
                foreach ($model as $val) {
                    echo "<option value='" . $val->id . "'>$val->transport_in_no</option>";
                }
            }
        } else {
            echo "";
        }
    }

    public function actionCreatepicking()
    {
        $sale = \Yii::$app->request->post("sale_id");
        if ($sale) {
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
            $model->status = 1;
            if ($model->save(false)) {
                if (count($prod) > 0) {
                    for ($i = 0; $i <= count($prod) - 1; $i++) {
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

            return $this->redirect(['update', 'id' => $sale]);


        }
        return "";

    }

    public function updateStock($pickingid)
    {
        $modelline = \backend\models\Pickingline::find()->where(['picking_id' => $pickingid])->all();
        if ($modelline) {
            $data = [];
            foreach ($modelline as $value) {
                array_push($data, [
                    'prod_id' => $value->product_id,
                    'qty' => $value->qty,
                    'warehouse_id' => $value->warehouse_id,
                    'trans_type' => TransType::TRANS_PICKING,
                    'permit_no' => $value->permit_no,
                    'transport_no' => $value->transport_in_no,
                    'excise_no' => $value->excise_no,
                ]);
            }
            $uptrans = TransCalculate::createJournal($data);
        }
    }

    public function actionPrint()
    {
        if (Yii::$app->request->isGet) {
            //  echo "ok";
            $id = Yii::$app->request->get('id');
            if ($id) {
                $this->redirect(['bill', 'id' => $id, ['target' => '_blank']]);
            }
        } else {
            // echo "no";
        }
    }

    public function actionBill($id)
    {
        $model = \backend\models\Picking::find()->where(['id' => $id])->one();
        $modelline = \backend\models\Pickingline::find()->where(['picking_id' => $id])->all();

        if ($model) {
            // return "nira";
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                //  'format' => [150,236], //manaul
                'format' => Pdf::FORMAT_A4,
                //'format' =>  Pdf::FORMAT_A5,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('_picking', [
                    'model' => $model,
                    'modelline' => $modelline,

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

    public function actionCreatepacking()
    {
        $id = \Yii::$app->request->post('saleid');

        if ($id) {
            return $this->redirect(['sale/showcreate', 'id' => $id]);
        }
    }

    public function actionShowcreate($id)
    {
        if ($id) {

            $model_check = \backend\models\Picking::find()->where(['sale_id'=>$id])->one();
            if($model_check){
                return $this->redirect(['sale/pickinghistory','id'=>$id]);
            }

            $model = \backend\models\Sale::find()->where(['id' => $id])->one();
            $modelline = \backend\models\Saleline::find()->where(['sale_id' => $id])->all();
            $data = [];
            if ($modelline) {
                foreach ($modelline as $value) {
                    array_push($data, $value->product_id);
                }
            }

            $sql = "SELECT t1.product_id,t1.qty,t1.price,t2.invoice_no,t2.invoice_date,t2.transport_in_no," .
                "t2.transport_in_date,t2.sequence,t2.permit_no,t2.permit_date,t2.kno_no_in,t2.kno_in_date,t3.origin," .
                "t2.thb_amount,t2.usd_rate,t1.stock_id,t1.sale_id,t1.id as sale_line_id,t4.require_date" .
                " FROM sale_line as t1 left join product_stock as t2 on t1.stock_id = t2.id inner join product as t3 on " .
                "t3.id = t1.product_id inner join sale as t4 on t1.sale_id = t4.id" .
                " WHERE t1.sale_id=" . $model->id;

            $query = Yii::$app->db->createCommand($sql)->queryAll();

            //print_r($query);return;


            $searchModel = new \backend\models\ProductstockSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andFilterWhere(['product_id' => $data]);

            return $this->render('_packingslip', [
                'model' => $model,
                'modelline' => $modelline,
                'query' => $query
                // 'searchModel'=> $searchModel,
                // 'dataProvider' => $dataProvider,
                //  'order_no' => $model->sale_no,
            ]);
//            return $this->render('_packingslip',[
//                'model'=>$model,
//                'modelline' => $modelline,
//            ]);
        }
    }

    public function actionSavepicking()
    {
        // echo 'niran';return;
        //if(Yii::$app->request->isAjax){
        // $list = Yii::$app->request->post('list');

        $sale_id = Yii::$app->request->post('sale_id');
        $sale_date = Yii::$app->request->post('sale_date');
        $sale_line_id = Yii::$app->request->post('sale_line_id');
        $stock_id = Yii::$app->request->post('stock_id');
        $line_qty = Yii::$app->request->post('line_qty');
        $line_price = Yii::$app->request->post('line_price');

        $trans_out_no = Yii::$app->request->post('line_transport_out_no');
        $trans_out_date = Yii::$app->request->post('line_transport_out_date');
        $kno_out_no = Yii::$app->request->post('line_kno_out_no');
        $kno_out_date = Yii::$app->request->post('line_kno_out_date');

        $sale_no = \backend\models\Sale::findSaleNo($sale_id);
        // $sale_date = \backend\models\Sale::findSaleDate($sale_id);

        $qty = 0;
        $price = 0;
        $pick_date = null;

        if ($sale_date != '') {
            //  echo  $linepermitdate[$i];return;
            $sale_date_x = explode('-', $sale_date);
            if (count($sale_date_x) > 0 && $sale_date_x[0] != '') {
                $pick_date = $sale_date_x[0] . "/" . $sale_date_x[1] . "/" . $sale_date_x[2];
            }
        }
//   echo $sale_date.'<br/>';
//        echo $pick_date;return;

        if (count($stock_id)) {

            $picking = new \backend\models\Picking();
            $picking->sale_id = $sale_id[0];
            $picking->getLastNo();
            $picking->trans_date = strtotime(date('Y-m-d'));
            $picking->picking_date = date('Y-m-d', strtotime($pick_date));
            if ($picking->save(false)) {
                if (count($stock_id) > 0) {
                    $data = [];
                    for ($i = 0; $i <= count($stock_id) - 1; $i++) {
                        // echo $trans_out_no[$i];return;
                        $trans_out_date_ok = null;
                        $kno_out_date_ok = null;

                        if ($trans_out_date[$i] != '') {
                            //  echo  $linepermitdate[$i];return;
                            $trans_date = explode('-', $trans_out_date[$i]);
                            if (count($trans_date) > 0 && $trans_date[0] != '') {
                                $trans_out_date_ok = $trans_date[0] . "/" . $trans_date[1] . "/" . $trans_date[2];
                            }
                        }
                        if ($kno_out_date[$i] != '') {
                            //  echo  $linepermitdate[$i];return;
                            $kno_date = explode('-', $kno_out_date[$i]);
                            if (count($kno_date) > 0 && $kno_date[0] != '') {
                                $kno_out_date_ok = $kno_date[0] . "/" . $kno_date[1] . "/" . $kno_date[2];
                            }
                        }
                        // echo $trans_out_date_ok.'   '.$trans_out_date[0];return;
                        $stock_info = \common\models\ProductStock::find()->where(['id' => $stock_id[$i]])->one();
                        if ($stock_info) {
                            $pickline = new \backend\models\Pickingline();
                            $pickline->picking_id = $picking->id;
                            $pickline->product_id = $stock_info->product_id;
                            $pickline->qty = $line_qty[$i];
                            $pickline->warehouse_id = $stock_info->warehouse_id;
                            $pickline->inv_no = $stock_info->invoice_no;
                            $pickline->inv_date = $stock_info->invoice_date;
                            $pickline->permit_no = $stock_info->permit_no;
                            $pickline->permit_date = $stock_info->permit_date;
                            //   $pickline->excise_no = $stock_info->excise_no;
                            $pickline->price = $line_price[$i];
                            $pickline->transport_out_no = $trans_out_no[$i];
                            $pickline->transport_out_date = date('Y-m-d', strtotime($trans_out_date_ok));
                            $pickline->kno_out_no = $kno_out_no[$i];
                            $pickline->kno_out_date = date('Y-m-d', strtotime($kno_out_date_ok));
                            //  $pickline->excise_date = $stock_info->excise_date;
                            $pickline->save(false);


                            array_push($data, [
                                'prod_id' => $stock_info->product_id,
                                'qty' => $line_qty[$i],
                                'warehouse_id' => $stock_info->warehouse_id,
                                'trans_type' => \backend\helpers\TransType::TRANS_ADJUST_OUT,
                                'permit_no' => $stock_info->permit_no,
                                'permit_date' => $stock_info->permit_date,//date('Y-d-m',strtotime($linepermitdate[$i])),
                                'transport_in_no' => $stock_info->transport_in_no,
                                'transport_in_date' => $stock_info->transport_in_date,//date('Y-d-m',strtotime($rowData[14])),
                                'excise_no' => '',
                                'excise_date' => date('Y-m-d'),
                                'invoice_no' => $sale_no,
                                'invoice_date' => date('Y-d-m', strtotime($pick_date)),//date('Y-d-m',strtotime($rowData[12])),
                                'sequence' => $stock_info->sequence,
                                'kno_no_in' => $stock_info->kno_no_in,
                                'kno_in_date' => $stock_info->kno_in_date,//date('Y-d-m',strtotime($rowData[19])),
                                'out_qty' => 0,
                                'usd_rate' => $stock_info->usd_rate,
                                'thb_amount' => $stock_info->usd_rate,
                                'inbound_id' => 0,
                                'outbound_id' => $sale_id[0],
                                'transport_out_no' => $trans_out_no[$i],
                                'transport_out_date' => date('Y-m-d', strtotime($trans_out_date_ok)),
                                'kno_out_no' => $kno_out_no[$i],
                                'kno_out_date' => date('Y-m-d', strtotime($kno_out_date_ok))

                            ]);

                        }
                    }
                    //  print_r($data);return;
                    $update_stock = \backend\models\TransCalculate::createJournal($data);
                    if ($update_stock) {
                        $session = Yii::$app->session;
                        $session->setFlash('msg', 'นำเข้าข้อมูลสินค้าเรียบร้อย');
                        return $this->redirect(['index']);
                    } else {
                        echo 'no';
                        return;
                        $session = Yii::$app->session;
                        $session->setFlash('msg-error', 'พบข้อมผิดพลาด');
                        return $this->redirect(['index']);
                    }
                }

            }
        }
        return $this->redirect(['sale/update', 'id' => $sale_id[0]]);
        //}
    }

    public function actionPrintinvoice($id)
    {
        $model = \backend\models\Sale::find()->where(['id' => $id])->one();
        $modelline = \backend\models\Saleline::find()->where(['sale_id' => $id])->all();

        if ($model) {
            // return "nira";
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                //  'format' => [150,236], //manaul
                'format' => Pdf::FORMAT_A4,
                //'format' =>  Pdf::FORMAT_A5,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('_invoice', [
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

            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];


//            $pdf->options['fontDir'] = array_merge($fontDirs, [
//               // Yii::getAlias('@backend').'/web/fonts'
//                Yii::$app->basePath
//            ]);

            $pdf->options = array_merge($pdf->options, [
                'fontDir' => array_merge($fontDirs, [Yii::$app->basePath . '/web/fonts']),  // make sure you refer the right physical path
                'fontdata' => array_merge($fontData, [
                    'angsana' => [
                        'R' => 'angsa.ttf',
//                        'I' => 'THSarabunNew Italic.ttf',
//                        'B' => 'THSarabunNew Bold.ttf',
                    ]
                ])
            ]);


//            $pdf->options['fontdata'] = $fontData + [
//                    'angsana' => [
//                        'R' => 'angsa.ttf',
//                        'TTCfontID' => [
//                            'R' => 1,
//                        ],
//                    ],
//                    'sarabun' => [
//                        'R' => 'Sarabun.ttf',
//                    ]
//                ];


            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            Yii::$app->response->headers->add('Content-Type', 'application/pdf');
            return $pdf->render();
        }
    }
    public function actionPickinghistory($id){
        if($id){
            $model = \backend\models\Picking::find()->where(['sale_id'=>$id])->one();
            if($model){
                $model_line = \backend\models\Pickingline::find()->where(['picking_id'=>$model->id])->all();

                return $this->render('_packhistory',[
                    'query'=> $model_line,
                    'sale_no' => \backend\models\Sale::findSaleNo($id)
                ]);
            }
        }
    }
}
