<?php

namespace backend\controllers;

use Yii;
use backend\models\Inboundinv;
use backend\models\InboundinvSearch;
use yii\base\Request;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use kartik\mpdf\Pdf;

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

            $model->invoice_date = date('Y-m-d', strtotime($inv_date));
            $model->status = 1;
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
                    $modelimport->kno_no_in = \backend\models\Plant::findKnoNo();
                    $modelimport->kno_in_date = \backend\models\Plant::findKnoDate();
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
        \backend\models\Importline::deleteAll(['import_id' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

    public function actionRecieve()
    {
        $productid = Yii::$app->request->post('product_id');
        $invoiceid = Yii::$app->request->post('invoice_id');
        $invoiceno = Yii::$app->request->post('invoice_no');
        $invoicedate = Yii::$app->request->post('invoice_date');
        $refid = Yii::$app->request->post('recid');
        $pack1 = Yii::$app->request->post('product_pack1');
        $pack2 = Yii::$app->request->post('product_pack2');
        $lineqty = Yii::$app->request->post('line_qty');
        $linepacking = Yii::$app->request->post('line_packing');
        $linepriceper = Yii::$app->request->post('line_price_per');
        $linetotalamount = Yii::$app->request->post('line_total_amount');
        $linetransportno = Yii::$app->request->post('line_transport_in_no');
        $linetransportdate = Yii::$app->request->post('line_transport_in_date');
        $linenum = Yii::$app->request->post('line_num');
        $linepermitno = Yii::$app->request->post('line_permit_no');
        $linepermitdate = Yii::$app->request->post('line_permit_date');
        $lineexciseno = Yii::$app->request->post('line_excise_no');
        $lineexcisedate = Yii::$app->request->post('line_excise_date');


        $permit_date = null;
        $transport_date = null;
        $inv_date = null;
        $trans_date = null;
        $kno_date = null;


//        $trans_origin = explode('/',$rowData[14]);
//        if(count($trans_origin)>0 && $trans_origin[0] !=''){
//            $trans_date = $trans_origin[2]."/".$trans_origin[1]."/".$trans_origin[0];
//        }
//
//        $inv_origin = explode('/',$rowData[12]);
//        if(count($inv_origin)>0 && $inv_origin[0] !=''){
//            $inv_date = $inv_origin[2]."/".$inv_origin[1]."/".$inv_origin[0];
//        }
//
//        $kno_origin = explode('/',$rowData[19]);
//        if(count($kno_origin)>0 && $kno_origin[0] !=''){
//            $kno_date = $kno_origin[2]."/".$kno_origin[1]."/".$kno_origin[0];
//        }


        if (count($productid) > 0) {

            for ($i = 0; $i <= count($productid) - 1; $i++) {
                $model = \backend\models\Inboundinvline::find()->where(['invoice_id' => $invoiceid, 'product_id' => $productid[$i]])->one();

                if ($linepermitdate[$i] != '') {
                    //  echo  $linepermitdate[$i];return;
                    $per_origin = explode('-', $linepermitdate[$i]);
                    if (count($per_origin) > 0 && $per_origin[0] != '') {
                        $permit_date = $per_origin[2] . "/" . $per_origin[1] . "/" . $per_origin[0];
                    }
                }
                if ($linetransportdate[$i] != '') {
                    //  echo  $linepermitdate[$i];return;
                    $trans_date = explode('-', $linetransportdate[$i]);
                    if (count($trans_date) > 0 && $trans_date[0] != '') {
                        $transport_date = $trans_date[2] . "/" . $trans_date[1] . "/" . $trans_date[0];
                    }
                }

                if ($model) {
                    $model->transport_in_no = $linetransportno[$i];
                    $model->transport_in_date = date('Y-m-d',strtotime($transport_date));
                    if ($model->save(false)) {
                        $modeltrans = \backend\models\Importline::find()->where(['import_id' => $refid[$i]])->one();
                        if ($modeltrans) {
                            $modeltrans->transport_in_no = $linetransportno[$i];
                            $modeltrans->transport_in_date = date('d-m-Y');
                            $modeltrans->posted = 1;
                            if ($modeltrans->save(false)) {

                            }
                        }
                    }

                }

                //$catid = $this->checkCat($rowData[6]);
                $whid = \backend\models\Warehouse::getDefault();

                $data = [];
                $usd = 100;//str_replace(",","",$rowData[21]);
                $thb = 100;//str_replace(",","",$rowData[22]);
                array_push($data, [
                    'prod_id' => $productid[$i],
                    'qty' => $lineqty[$i],
                    'warehouse_id' => $whid,
                    'trans_type' => \backend\helpers\TransType::TRANS_ADJUST_IN,
                    'permit_no' => $linepermitno[$i],
                    'permit_date' => $permit_date,//date('Y-d-m',strtotime($linepermitdate[$i])),
                    'transport_in_no' => $linetransportno[$i],
                    'transport_in_date' => $linetransportdate[$i],//date('Y-d-m',strtotime($rowData[14])),
                    'excise_no' => $lineexciseno[$i],
                    'excise_date' => date('Y-d-m', strtotime($lineexcisedate[$i])),
                    'invoice_no' => $invoiceno,
                    'invoice_date' => date('Y-d-m', strtotime($invoicedate)),//date('Y-d-m',strtotime($rowData[12])),
                    'sequence' => $linenum[$i],
                    'kno_no_in' => 1,
                    'kno_in_date' => date('Y-d-m'),//date('Y-d-m',strtotime($rowData[19])),
                    'out_qty' => 0,
                    'usd_rate' => $usd,
                    'thb_amount' => $thb,

                ]);


            }

            print_r($data);return;

            $update_stock = \backend\models\TransCalculate::createJournal($data);
            if ($update_stock) {
                $session = Yii::$app->session;
                $session->setFlash('msg', 'นำเข้าข้อมูลสินค้าเรียบร้อย');
                return $this->redirect(['index']);
            } else {
                $session = Yii::$app->session;
                $session->setFlash('msg-error', 'พบข้อมผิดพลาด');
                return $this->redirect(['index']);
            }


        }
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
}
