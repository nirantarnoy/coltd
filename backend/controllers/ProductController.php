<?php

namespace backend\controllers;

use backend\models\Uploadfile;
use backend\models\Vendor;
use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use backend\helpers\TransType;
use backend\models\TransCalculate;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\imagine\Image;
use \backend\models\Productstock;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST', 'GET'],
                    'findvendor' => ['POST'],
                ],
            ],
//            'access'=>[
//                'class'=>AccessControl::className(),
//                'denyCallback' => function ($rule, $action) {
//                    throw new ForbiddenHttpException('คุณไม่ได้รับอนุญาติให้เข้าใช้งาน!');
//                },
//                'rules'=>[
////                    [
////                        'allow'=>true,
////                        'actions'=>['index','create','update','delete','view'],
////                        'roles'=>['@'],
////                    ]
//                    [
//                        'allow'=>true,
//                        'roles'=>['@'],
//                        'matchCallback'=>function($rule,$action){
//                            $currentRoute = Yii::$app->controller->getRoute();
//                            if(Yii::$app->user->can($currentRoute)){
//                                return true;
//                            }
//                        }
//                    ]
//                ]
//            ]
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $group = [];
        $stockstatus = [];
        $searcname = '';
        if (Yii::$app->request->isPost) {
            $group = Yii::$app->request->post('product_group');
            $stockstatus = Yii::$app->request->post('stock_status');
            $searcname = Yii::$app->request->post('search_all');

        }


        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['category_id' => $group])->andFilterWhere(['OR', ['LIKE', 'product_code', $searcname], ['LIKE', 'name', $searcname]]);
        if (count($stockstatus) > 1) {
            if (in_array("1", $stockstatus, true) and in_array("2", $stockstatus, true) and in_array("3", $stockstatus, true)) {

            } else if (in_array("1", $stockstatus, true) and in_array("2", $stockstatus, true)) {
                $dataProvider->query->andFilterWhere(['>', 'all_qty', 0]);
            } else if (in_array("1", $stockstatus, true) and in_array("3", $stockstatus, true)) {
                $dataProvider->query->andFilterWhere(['OR', ['AND', ['>', 'all_qty', 0], ['<=', 'min_stock', 'all_qty']], ['=', 'all_qty', 0]]);
            } else if (in_array("2", $stockstatus, true) and in_array("3", $stockstatus, true)) {
                $dataProvider->query->andFilterWhere(['OR', ['>', 'min_stock', 'all_qty'], ['=', 'all_qty', 0]]);
            }

        } else if (count($stockstatus) > 0 and count($stockstatus) < 2) {
            //echo $stockstatus[0];return;
            if ($stockstatus[0] == "1") {
                $dataProvider->query->andFilterWhere(['AND', ['>', 'all_qty', 0], ['<=', 'min_stock', 'all_qty']]);
            } else if ($stockstatus[0] == "2") {
                $dataProvider->query->andFilterWhere(['>', 'min_stock', 'all_qty']);
            } else if ($stockstatus[0] == "3") {
                $dataProvider->query->andFilterWhere(['=', 'all_qty', 0]);
            }
        }


        $dataProvider->pagination->pageSize = $pageSize;
        $modelupload = new \backend\models\Uploadfile();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
            'viewtype' => 'list',
            'modelupload' => $modelupload,
            'group' => $group,
            'stockstatus' => $stockstatus,
            'searchname' => $searcname,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        // $modeljournalline = \backend\models\Journalline::find()->where(['product_id'=>$id])->all();
        //  $uploadfile = new \backend\models\Uploadfile();

        //echo strtotime(date_format($start,'d-m-Y'));
        // echo strtotime() ."-". strtotime(trim($dt_range[1]));
        //  $movementSearch = new \backend\models\MovementSearch();
        //  $movementDp = $movementSearch->search(Yii::$app->request->queryParams);
        // $movementDp->pagination->pageSize = 10;
        // $movementDp->query->andFilterWhere(['product_id'=>$id]);
//        if(isset(Yii::$app->request->queryParams['MovementSearch']['created_at'])){
//            $dt = Yii::$app->request->queryParams['MovementSearch']['created_at'];
//            $dt_range = explode("to",$dt);
//            $start = date_create(trim($dt_range[0]));
//           // $end = date_create(trim($dt_range[1]));
//           // $movementDp->query->andFilterWhere(['between','created_at',strtotime(date_format($start,'d-m-Y')),strtotime(date_format($end,'d-m-Y'))]);
//
//        }

        // $photoes = \backend\models\Productgallery::find()->where(['product_id'=>$id])->all();
        $productimage = \backend\models\Productimage::find()->where(['product_id' => $id])->all();
        //  $modelcost = \backend\models\Productcost::find()->where(['product_id'=>$id])->all();
        $modelcost = \backend\models\Productstock::find()->where(['product_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'productimage' => $productimage,
            'modelcost' => $modelcost,
            // 'modeljournalline' => $modeljournalline,
            //  'photoes'=>$photoes,
            //  'uploadfile'=>$uploadfile,
            //  'movementDp' => $movementDp,
            //   'movementSearch'=> $movementSearch,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $modelfile = new \backend\models\Modelfile();

        if ($model->load(Yii::$app->request->post()) && $modelfile->load(Yii::$app->request->post())) {
            $uploadimage = UploadedFile::getInstances($modelfile, 'file_photo');
            $model->excise_date = date('Y-m-d', strtotime($model->excise_date));
            if ($model->save()) {

                if (!empty($uploadimage)) {

                    foreach ($uploadimage as $file) {

                        $file->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/' . $file);
                        Image::thumbnail(Yii::getAlias('@backend') . '/web/uploads/images/' . $file, 100, 70)
                            ->rotate(0)
                            ->save(Yii::getAlias('@backend') . '/web/uploads/thumbnail/' . $file, ['jpeg_quality' => 100]);

                        $modelfile = new \backend\models\Productimage();
                        $modelfile->product_id = $model->id;
                        $modelfile->name = $file;
                        $modelfile->save(false);
                    }
                }

                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'modelfile' => $modelfile
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelfile = new \backend\models\Modelfile();
        $productimage = \backend\models\Productimage::find()->where(['product_id' => $id])->all();


        if ($model->load(Yii::$app->request->post()) && $modelfile->load(Yii::$app->request->post())) {
            $uploadimage = UploadedFile::getInstances($modelfile, 'file_photo');
            $model->excise_date = date('Y-m-d', strtotime($model->excise_date));
            if ($model->save()) {

                if (!empty($uploadimage)) {

                    foreach ($uploadimage as $file) {

                        $file->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/' . $file);
                        Image::thumbnail(Yii::getAlias('@backend') . '/web/uploads/images/' . $file, 100, 70)
                            ->rotate(0)
                            ->save(Yii::getAlias('@backend') . '/web/uploads/thumbnail/' . $file, ['jpeg_quality' => 100]);

                        $modelfile = new \backend\models\Productimage();
                        $modelfile->product_id = $model->id;
                        $modelfile->name = $file;
                        $modelfile->save(false);
                    }
                }

                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }

        }

        return $this->render('update', [
            'model' => $model,
            'modelfile' => $modelfile,
            'productimage' => $productimage,

        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        $session = Yii::$app->session;
        $session->setFlash('msg', 'ลบรหัสสินค้าเรียบร้อย');
        return $this->redirect(['index']);
    }

    public function actionDeleteAll()
    {
        $delete_ids = explode(',', Yii::$app->request->post('ids'));
        Product::deleteAll(['in', 'id', $delete_ids]);
        $session = Yii::$app->session;
        $session->setFlash('msg', 'ลบรหัสสินค้าเรียบร้อย');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionExporttemplate()
    {
        $strExcelFileName = "form_product.xls";
        header('Content-Encoding: UTF-8');
        header("Content-Type: application/x-msexcel ; name=\"$strExcelFileName\" charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$strExcelFileName\"");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "
           <table border='1'>
             <tr>
                <td>Product Code</td>
                <td>Name</td>
                <td>Category</td>
                <td>Unit</td>
                <td>Qty</td>
                <td>Price</td>
                <td>Cost</td>
            </tr>
            </table>
        ";
    }

    public function actionImportproduct()
    {
        //echo "ok";return;
        $model = new \backend\models\Uploadfile();
        $qty_text = [];
        if (Yii::$app->request->post()) {
            $uploaded = UploadedFile::getInstance($model, 'file');
            if (!empty($uploaded)) {
                $upfiles = time() . "." . $uploaded->getExtension();
                if ($uploaded->saveAs('../web/uploads/files/' . $upfiles)) {
                    //echo "okk";return;
                    $myfile = '../web/uploads/files/' . $upfiles;
                    $file = fopen($myfile, "r");
                    fwrite($file, "\xEF\xBB\xBF");

                    setlocale(LC_ALL, 'th_TH.TIS-620');
                    $i = -1;
                    $res = 0;
                    $data = [];
                    while (($rowData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $i += 1;
                        $catid = 0;
                        $qty = 0;
                        $price = 0;
                        $cost = 0;

                        $permit_date = null;
                        $inv_date = null;
                        $trans_date = null;
                        $kno_date = null;


                        if ($rowData[1] == '' || $i == 0) {
                            continue;
                        }

                        $per_origin = explode('/', $rowData[17]);
                        if (count($per_origin) > 0 && $per_origin[0] != '') {

                            //print_r($per_origin);return;
                            $permit_date = $per_origin[2] . "/" . $per_origin[1] . "/" . $per_origin[0];
//                            if($rowData[0] =='C-007'){
//                                echo $permit_date;return;
//                            }
                        }

                        $trans_origin = explode('/', $rowData[14]);
                        if (count($trans_origin) > 0 && $trans_origin[0] != '') {
                            $trans_date = $trans_origin[2] . "/" . $trans_origin[1] . "/" . $trans_origin[0];
                        }

                        $inv_origin = explode('/', $rowData[12]);
                        if (count($inv_origin) > 0 && $inv_origin[0] != '') {
                            $inv_date = $inv_origin[2] . "/" . $inv_origin[1] . "/" . $inv_origin[0];
                        }

//                        $kno_origin = explode('/', $rowData[19]);
//                        if (count($kno_origin) > 0 && $kno_origin[0] != '') {
//                            $kno_date = $kno_origin[2] . "/" . $kno_origin[1] . "/" . $kno_origin[0];
//                        }


                        if ($rowData[24] != '' && $rowData[24] != null) {
                            $qty_separate = explode(' ', $rowData[24]);
                            if (count($qty_separate) > 1) {
                                $qty = $qty_separate[1] == NULL || $qty_separate[1] == '' ? 0 : str_replace(",", "", $qty_separate[1]);
                            } else {
                                $qty = $rowData[24];
                            }
                        }

                        //  $permit_date = '02/08/2019';

                        // array_push($qty_text, $rowData[24]);continue;
                        $price = $rowData[21] == NULL || $rowData[21] == '' ? 0 : str_replace(",", "", $rowData[21]);
                        $catid = $this->checkCat($rowData[6]);
                        $whid = $this->checkWarehouse($rowData[10]);

                        if (!$whid) {
                            $whid = \backend\models\Warehouse::getDefault();
                        }

                        $modelprod = \backend\models\Product::find()->where(['name' => $rowData[1]])->one();
                        if (count($modelprod) > 0) {
                            // echo "oo";return;
                            // $data_all +=1;
                            // array_push($data_fail,['name'=>$rowData[0][1]]);
                            $modelstock = \backend\models\Productstock::find()->where(['product_id' => $modelprod->id, 'invoice_no' => $rowData[11], 'transport_in_no' => $rowData[13]])->one();
                            if ($modelstock) {
                                continue;
                            } else {
                                $usd = str_replace(",", "", $rowData[21]);
                                $thb = str_replace(",", "", $rowData[22]);
                                array_push($data, [
//                                    'prod_id'=>$modelprod->id,
//                                    'qty'=>$qty,
//                                    'warehouse_id'=>$whid,
//                                    'trans_type'=>TransType::TRANS_ADJUST_IN,
//                                    'permit_no' => $rowData[16],
//                                    'permit_date' => trim($rowData[17]),
//                                    'transport_in_no' => $rowData[13],
//                                    'transport_in_date' => trim($rowData[14]),
//                                    'excise_no' => '',
//                                    'invoice_no' => $rowData[11],
//                                    'invoice_date' => trim($rowData[12]),
//                                    'sequence' => $rowData[15],
//                                    'kno_no_in' => $rowData[18],
//                                    'kno_in_date' => trim($rowData[19]),
//                                    'out_qty' => 0,
//                                    'usd_rate' => $usd,
//                                    'thb_amount' => $thb,

                                    'prod_id' => $modelprod->id,
                                    'qty' => $qty,
                                    'warehouse_id' => $whid,
                                    'trans_type' => TransType::TRANS_ADJUST_IN,
                                    'permit_no' => $rowData[16],
//                                 'permit_date' => date('Y-m-d',strtotime($rowData[17])),
                                    'permit_date' => $permit_date,
                                    'transport_in_no' => $rowData[13],
                                    //  'transport_in_date' => date('Y-m-d',strtotime($rowData[14])),
                                    'transport_in_date' => $trans_date,
                                    'excise_no' => '',
                                    'invoice_no' => $rowData[11],
                                    //'invoice_date' => date('Y-m-d',strtotime($rowData[12])),
                                    'invoice_date' => $inv_date,
                                    'sequence' => $rowData[15],
                                    'kno_no_in' => $rowData[18],
                                    //   'kno_in_date' => date('Y-m-d',strtotime($rowData[19])),
                                    'kno_in_date' => $kno_date,
                                    'out_qty' => 0,
                                    'usd_rate' => $usd,
                                    'thb_amount' => $thb,
                                    'line_num' => $rowData[15]


                                ]);
                                // print_r($data);return;
                                // $update_stock = TransCalculate::createJournal($data);
                            }
                            continue;
                        }


                        $modelx = new \backend\models\Product();
                        $modelx->product_code = $rowData[0];
                        $modelx->barcode = $rowData[0];
                        $modelx->engname = ltrim($rowData[1]);
                        $modelx->name = ltrim($rowData[1]);
                        $modelx->category_id = $catid;
                        // $modelx->unit_id = $this->checkUnit($rowData[3]);
                        $modelx->description =$rowData[26] ;
                        $modelx->price = $price;//$rowData[5];
                        $modelx->cost = $price; //$rowData[6];
                        $modelx->origin = $rowData[7];
                        $modelx->unit_factor = $rowData[2];
                        $modelx->volumn = $rowData[3];
                        $modelx->volumn_content = $rowData[4];
                        $modelx->excise_no = $rowData[8];
                        $modelx->all_qty = (int)$qty;
                        $modelx->price_carton_thb = str_replace(",", "", $rowData[24]); //ราคาต่อลัง
                        $modelx->excise_date = date('Y-m-d', strtotime($rowData[9]));

                        $this->updatePositiongroup($catid, $rowData[5]);
                        //  $modelx->all_qty = str_replace(',','', $rowData[8]);
                        //    $modelx->available_qty = str_replace(',','', $rowData[8]);
                        $modelx->status = 1;


                        $transport_in_no = '';
                        $transport_in_date = '';
                        $permit_no = '';
                        $permit_date = '';
                        $excise_no = '';
                        $excise_date = '';

                        if ($modelx->save(false)) {
                            $res += 1;
                            //      $this->manageprodstock($whid,$modelx->id,$modelx->all_qty,);
                            //     $data_all +=1;
                            $usd = str_replace(",", "", $rowData[21]);
                            $thb = str_replace(",", "", $rowData[22]);
                            array_push($data, [
                                'prod_id' => $modelx->id,
                                'qty' => $modelx->all_qty,
                                'warehouse_id' => $whid,
                                'trans_type' => TransType::TRANS_ADJUST_IN,
                                'permit_no' => $rowData[16],
//                                 'permit_date' => date('Y-m-d',strtotime($rowData[17])),
                                'permit_date' => $permit_date,
                                'transport_in_no' => $rowData[13],
                                //  'transport_in_date' => date('Y-m-d',strtotime($rowData[14])),
                                'transport_in_date' => $trans_date,
                                'excise_no' => $excise_no,
                                'invoice_no' => $rowData[11],
                                //'invoice_date' => date('Y-m-d',strtotime($rowData[12])),
                                'invoice_date' => $inv_date,
                                'sequence' => $rowData[15],
                                'kno_no_in' => $rowData[18],
                                //   'kno_in_date' => date('Y-m-d',strtotime($rowData[19])),
                                'kno_in_date' => $kno_date,
                                'out_qty' => 0,
                                'usd_rate' => $usd,
                                'thb_amount' => $thb,
                                'line_num' => $rowData[15]

                            ]);
                        }
                    }
                    //    print_r($qty_text);return;
                    $this->createInvoicefromimport($data);
                    $update_stock = TransCalculate::createJournal($data);
                    if ($res > 0 && $update_stock) {
                        $session = Yii::$app->session;
                        $session->setFlash('msg', 'นำเข้าข้อมูลสินค้าเรียบร้อย');
                        return $this->redirect(['index']);
                    } else {
                        $session = Yii::$app->session;
                        $session->setFlash('msg-error', 'พบข้อมผิดพลาด');
                        return $this->redirect(['index']);
                    }
                }
                fclose($file);
            } else {

            }
        }
    }
    public function createInvoicefromimport($data){
//        $x_date = explode('/', $inv_date);
//        $inv_date = date('Y-m-d');
//        if (count($x_date)) {
//            $inv_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
//        }
//
//        $cur = 1;
//        if($model->currency_id == '' || $model->currency_id == null){
//            $cur = 1;
//        }else{
//            $cur = $model->currency_id;
//        }

        //echo $cur;return;

        if(count($data)>0){
            for($i=0;$i<=count($data)-1;$i++){
                $inv_no = $data[$i]['invoice_no'];
                $inv_date = $data[$i]['invoice_date'];

                $chk_old = \backend\models\Inboundinv::find()->where(['invoice_no'=>$inv_no])->one();
                if($chk_old != null){
                    $model_line = new \backend\models\Inboundinvline();
                    $model_line->invoice_id = $chk_old->id;
                    $model_line->product_id = $data[$i]['prod_id'];
                    $model_line->permit_no = $data[$i]['permit_no'];
                    $model_line->permit_date = $data[$i]['permit_date'];
                    $model_line->kno_no_in = $data[$i]['kno_no_in'];
                    $model_line->kno_in_date = $data[$i]['kno_in_date'];
                    $model_line->transport_in_no = $data[$i]['transport_in_no'];
                    $model_line->transport_in_date = $data[$i]['transport_in_date'];
                    $model_line->line_num = $data[$i]['line_num'];
                    $model_line->line_price = $data[$i]['usd_rate'];
                    $model_line->line_qty = $data[$i]['qty'];
                    $model_line->save(false);
                }else{
                    $model = new \backend\models\Inboundinv();
                    $model->invoice_no = $inv_no;
                    $model->invoice_date = date('Y-m-d', strtotime($inv_date));
                    $model->status = 1;
                    $model->currency_id = 1; // USD default
                    if($model->save(false)){
                        $model_line = new \backend\models\Inboundinvline();
                        $model_line->invoice_id = $model->id;
                        $model_line->product_id = $data[$i]['prod_id'];
                        $model_line->permit_no = $data[$i]['permit_no'];
                        $model_line->permit_date = $data[$i]['permit_date'];
                        $model_line->kno_no_in = $data[$i]['kno_no_in'];
                        $model_line->kno_in_date = $data[$i]['kno_in_date'];
                        $model_line->transport_in_no = $data[$i]['transport_in_no'];
                        $model_line->transport_in_date = $data[$i]['transport_in_date'];
                        $model_line->line_num = $data[$i]['line_num'];
                        $model_line->line_price = $data[$i]['usd_rate'];
                        $model_line->line_qty = $data[$i]['qty'];
                        $model_line->save();
                    }
                }
            }
        }


    }
    public function manageprodstock($whid, $prodid, $qty, $usd, $thb, $whdata, $invno, $trans_in_no)
    {
        $whid = 0;
//        $prodid = \backend\models\Product::findId($rowData[0]);
//        $qty = str_replace(",","",$rowData[20]);
//        $usd = str_replace(",","",$rowData[21]);
//        $thb = str_replace(",","",$rowData[22]);
        $wh_get_id = \backend\models\Warehouse::find()->where(['name' => $whdata])->one();
        if ($wh_get_id) {
            $whid = $wh_get_id->id;
        }

        // $qty = 100;
        //echo $rowData[11];
        $has_stock = Productstock::find()->where(['product_id' => $prodid, 'warehouse_id' => $whid,
            'invoice_no' => $invno, 'transport_in_no' => $trans_in_no])->one();
        if ($has_stock) {
            $has_stock->in_qty = $qty;
            $has_stock->out_qty = 0;
            $has_stock->usd_rate = $usd;
            $has_stock->thb_amount = $thb;
            $has_stock->save(false);
        } else {
            $modelstock = new Productstock();
            $modelstock->product_id = $prodid;
            $modelstock->warehouse_id = $whid;
            $modelstock->invoice_no = $rowData[11];
            $modelstock->invoice_date = date('Y-m-d', strtotime($rowData[12]));
            $modelstock->transport_in_no = $rowData[13];
            $modelstock->transport_in_date = date('Y-m-d', strtotime($rowData[14]));
            $modelstock->sequence = $rowData[15];
            $modelstock->permit_no = $rowData[16];
            $modelstock->permit_date = date('Y-m-d', strtotime($rowData[17]));
            $modelstock->kno_no_in = $rowData[18];
            $modelstock->kno_in_date = date('Y-m-d', strtotime($rowData[19]));
            $modelstock->in_qty = $qty;
            $modelstock->out_qty = 0;
            $modelstock->usd_rate = $usd;
            $modelstock->thb_amount = $thb;
            $modelstock->save(false);
        }
    }

    public function actionImportupdate()
    {
        $model = new \backend\models\Uploadfile();
        if (Yii::$app->request->post()) {
            $uploaded = UploadedFile::getInstance($model, 'file');
            if (!empty($uploaded)) {
                $upfiles = time() . "." . $uploaded->getExtension();
                if ($uploaded->saveAs('../web/uploads/files/' . $upfiles)) {
                    //echo "okk";return;
                    $myfile = '../web/uploads/files/' . $upfiles;
                    $file = fopen($myfile, "r");
                    fwrite($file, "\xEF\xBB\xBF");

                    setlocale(LC_ALL, 'th_TH.TIS-620');
                    $i = -1;
                    $res = 0;
                    $data = [];
                    while (($rowData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $i += 1;
                        if ($rowData[1] == '' || $i == 0) {
                            continue;
                        }


                        $has_product = \backend\models\Product::find()->where(['product_code' => $rowData[0]])->one();
                        if ($has_product) {
                            $whid = 0;
                            $prodid = \backend\models\Product::findId($rowData[0]);
                            $qty = str_replace(",", "", $rowData[20]);
                            $usd = str_replace(",", "", $rowData[21]);
                            $thb = str_replace(",", "", $rowData[22]);
                            $wh_get_id = \backend\models\Warehouse::find()->where(['name' => $rowData[10]])->one();
                            if ($wh_get_id) {
                                $whid = $wh_get_id->id;
                            }

                            // $qty = 100;
                            //echo $rowData[11];
                            $has_stock = Productstock::find()->where(['product_id' => $has_product->id, 'warehouse_id' => $whid,
                                'invoice_no' => $rowData[11], 'transport_in_no' => $rowData[13]])->one();
                            if ($has_stock) {
                                $has_stock->in_qty = $qty;
                                $has_stock->out_qty = 0;
                                $has_stock->usd_rate = $usd;
                                $has_stock->thb_amount = $thb;
                                if ($has_stock->save(false)) {
                                    $this->sumOnhand($has_product->prodid);
                                }
                            } else {
                                $modelstock = new Productstock();
                                $modelstock->product_id = $prodid;
                                $modelstock->warehouse_id = $whid;
                                $modelstock->invoice_no = $rowData[11];
                                $modelstock->invoice_date = date('Y-m-d', strtotime($rowData[12]));
                                $modelstock->transport_in_no = $rowData[13];
                                $modelstock->transport_in_date = date('Y-m-d', strtotime($rowData[14]));
                                $modelstock->sequence = $rowData[15];
                                $modelstock->permit_no = $rowData[16];
                                $modelstock->permit_date = date('Y-m-d', strtotime($rowData[17]));
                                $modelstock->kno_no_in = $rowData[18];
                                $modelstock->kno_in_date = date('Y-m-d', strtotime($rowData[19]));
                                $modelstock->in_qty = $qty;
                                $modelstock->out_qty = 0;
                                $modelstock->usd_rate = $usd;
                                $modelstock->thb_amount = $thb;
                                if ($modelstock->save(false)) {
                                    $this->sumOnhand($has_product->prodid);
                                }
                            }
                        }
                    }
                    $session = Yii::$app->session;
                    $session->setFlash('msg', 'นำเข้าข้อมูลสินค้าเรียบร้อย');
                    return $this->redirect(['index']);

//                        $catid = 0;
//                        $qty = 0;
//                        $price = 0;
//
//                        $qty = str_replace(",","",$rowData[24]);
//                        $price = str_replace(",","",$rowData[21]);
//                        $catid = $this->checkCat($rowData[6]);
//
//
//                        $modelx = new \backend\models\Product();
//                        $modelx->product_code = $rowData[0];
//                        $modelx->barcode = $rowData[0];
//                        $modelx->engname = ltrim($rowData[1]);
//                        $modelx->name = ltrim($rowData[1]);
//                        $modelx->category_id = $catid;
//                        // $modelx->unit_id = $this->checkUnit($rowData[3]);
//                        $modelx->description = '';//$rowData[1] ;
//                        $modelx->price = $price;//$rowData[5];
//                        $modelx->cost = $price; //$rowData[6];
//                        $modelx->origin = $rowData[7];
//                        $modelx->unit_factor = $rowData[2];
//                        $modelx->volumn = $rowData[3];
//                        $modelx->volumn_content = $rowData[4];
//                        $modelx->excise_no = $rowData[8];
//                        $modelx->all_qty = $qty;
//                        $modelx->excise_date = date('Y-m-d',strtotime($rowData[9]));
//
//                        $this->updatePositiongroup($catid,$rowData[5]);
//                        //  $modelx->all_qty = str_replace(',','', $rowData[8]);
//                        //    $modelx->available_qty = str_replace(',','', $rowData[8]);
//                        $modelx->status = 1;
//
//
//                        $transport_in_no = '';
//                        $transport_in_date = '';
//                        $permit_no = '';
//                        $permit_date = '';
//                        $excise_no = '';
//                        $excise_date = '';
//
//                        if ($modelx->save(false)) {
//                            $res += 1;
//                            // $data_all +=1;
//                            array_push($data,[
//                                'prod_id'=>$modelx->id,
//                                'qty'=>$modelx->all_qty,
//                                'warehouse_id'=>1,
//                                'trans_type'=>TransType::TRANS_ADJUST_IN,
//                                'permit_no' => $permit_no,
//                                'transport_no' => $transport_in_no,
//                                'excise_no' => $excise_no,
//                            ]);
//                        }
//                    }
//                    $update_stock = TransCalculate::createJournal($data);
//                    if($res > 0 && $update_stock){
//                        $session = Yii::$app->session;
//                        $session->setFlash('msg','นำเข้าข้อมูลสินค้าเรียบร้อย');
//                        return $this->redirect(['index']);
//                    }else{
//                        $session = Yii::$app->session;
//                        $session->setFlash('msg-error','พบข้อมผิดพลาด');
//                        return $this->redirect(['index']);
//                    }
                }
                fclose($file);
            } else {

            }
        }
    }

    public function sumOnhand($prodid)
    {
        $onhand = \backend\models\Productstock::find()->where(['prod_id' => $prodid])->sum('qty');
        $upproduct = \backend\models\Product::find()->where()->one();
    }

    public function updatePositiongroup($groupid, $position)
    {
        $model = \backend\models\Productcategory::find()->where(['name' => $groupid])->one();
        if ($model) {
            $model->geolocation = $position;
            $model->save();
        }
    }

    public function cal_import_qty($product_id)
    {
        $model = \backend\models\Productcost::find()->where(['product_id' => $product_id])->all();
        if ($model) {
            $total_qty = 0;
            foreach ($model as $value) {
                $total_qty += $value->qty;
            }
            $modelupdate = \backend\models\product::find()->where(['id' => $product_id])->one();
            $modelupdate->all_qty = $total_qty;
            $modelupdate->available_qty = $total_qty;
            $modelupdate->save(false);
        }
    }

    public function checkCat($name)
    {
        $model = \backend\models\Productcategory::find()->where(['name' => ltrim($name)])->one();
        if (count($model) > 0) {
            return $model->id;
        } else {
            if ($name != '') {
                $model_new = new \backend\models\Productcategory();
                $model_new->name = ltrim($name);
                $model_new->status = 1;
                if ($model_new->save(false)) {
                    return $model_new->id;
                }
            } else {
                return 0;
            }
        }
    }

    public function checkWarehouse($name)
    {
        $model = \backend\models\Warehouse::find()->where(['name' => ltrim($name)])->one();
        if (count($model) > 0) {
            return $model->id;
        } else {
            if ($name != '') {
                $model_new = new \backend\models\Warehouse();
                $model_new->name = ltrim($name);
                $model_new->status = 1;
                if ($model_new->save(false)) {
                    return $model_new->id;
                }
            } else {
                return 0;
            }
        }
    }

    public function checkUnit($name)
    {
        $model = \backend\models\Unit::find()->where(['name' => $name])->one();
        if (count($model) > 0) {
            return $model->id;
        } else {
            if ($name != '') {
                $model_new = new \backend\models\Unit();
                $model_new->name = $name;
                $model_new->status = 1;
                if ($model_new->save(false)) {
                    return $model_new->id;
                }
            } else {
                return 0;
            }
        }
    }

    public function actionPrintbarcode()
    {
        if (Yii::$app->request->post()) {
            $prod_id = Yii::$app->request->post('product_listid');
            $paper_type = Yii::$app->request->post('paper_type');
            $paper_format = Yii::$app->request->post('paper_format');
            $qty = Yii::$app->request->post('qty');

            $show_code = Yii::$app->request->post('show_code');
            $show_name = Yii::$app->request->post('show_name');

            $prodid = explode(',', $prod_id);
            $paper_size = Pdf::FORMAT_LEGAL;
            $orient = Pdf::ORIENT_PORTRAIT;

            if ($paper_format == 1) {
                $orient = Pdf::ORIENT_LANDSCAPE;
            }
            if ($paper_type == 0) {
                $paper_size = [100, 50];
            } else if ($paper_type == 1) {
                $paper_size = Pdf::FORMAT_A4;
            } else if ($paper_type == 2) {
                $paper_size = Pdf::FORMAT_LETTER;
            }


            $modellist = Product::find()->where(['id' => $prodid])->all();

            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'format' => $paper_size,
                // 'format' => [60, 30],//กำหนดขนาด
                'orientation' => $orient,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('_print', [
                    'list' => $modellist,
                    'barcode_qty' => $qty,
                    'show_code' => $show_code,
                    'show_name' => $show_name,
                    // 'from_date'=> $from_date,
                    // 'to_date' => $to_date,
                ]),
                //'content' => "nira",
                'cssFile' => '@backend/web/css/pdf.css',
                // 'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
                'options' => [
                    'title' => 'บาร์โต้ดรหัสสินค้า',
                    'subject' => ''
                ],
                'methods' => [
                    //  'SetHeader' => ['บาร์โค้ดรหัสสินค้า||Generated On: ' . date("r")],
                    //  'SetFooter' => ['|Page {PAGENO}|'],
                ]
            ]);
            return $pdf->render();

        }
    }

    public function actionExport($type)
    {
        if ($type != '') {

            $contenttype = "";
            $fileName = "";

            if ($type == 'xsl') {
                $contenttype = "application/x-msexcel";
                $fileName = "export_product.xls";
            }
            if ($type == 'csv') {
                $contenttype = "application/csv";
                $fileName = "export_product.csv";
            }

            header('Content-Encoding: UTF-8');
            header("Content-Type: " . $contenttype . " ; name=\"$fileName\" ;charset=utf-8");
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 0");

            print "\xEF\xBB\xBF";

            $model = Product::find()->where(['id' => 1])->all();
            if ($model) {
                echo "
                       <table border='1'>
                         <tr>
                            <td>Product Code</td>
                            <td>Name</td>
                            <td>Category</td>
                            <td>Unit</td>
                            <td>Qty</td>
                            <td>Price</td>
                            <td>Cost</td>
                        </tr>
                       
                    ";
                foreach ($model as $data) {
                    $cat = \backend\models\Productcat::findGroupname($data->category_id);
                    $unit = \backend\models\Unit::findUnitname($data->unit_id);
                    echo "
                        <tr>
                            <td>$data->product_code</td>
                            <td>$data->name</td>
                            <td>$cat</td>
                            <td>$unit</td>
                            <td>$data->all_qty</td>
                            <td>$data->price</td>
                            <td>$data->cost</td>
                        </tr>
                    ";
                }
                echo "</table>";
            }
        }
    }

    public function actionUploadphoto()
    {
        $model = new Uploadfile();
        $prodid = Yii::$app->request->post('product_id');
        $uploaded = UploadedFile::getInstances($model, 'file');
        if (!empty($uploaded)) {
            //print_r($uploaded);return;
            foreach ($uploaded as $data) {
                $modelphoto = new \backend\models\Productgallery();
                $upfiles = time() . "." . $data->getExtension();
                if ($data->saveAs('../web/uploads/gallery/' . $upfiles)) {
                    $modelphoto->product_id = $prodid;
                    $modelphoto->photo = $upfiles;
                }
                $modelphoto->save(false);

            }
        }
        return $this->redirect(['view', 'id' => $prodid]);
    }

    public function actionDeletephoto()
    {
        $id = \Yii::$app->request->post('id');
        \backend\models\Productimage::deleteAll(['id' => $id]);
        // return $this->redirect(['view','id'=>$prodid]);
        return true;
    }
//    public function actionDeletephoto($id,$prodid){
//        \backend\models\Productgallery::deleteAll(['id'=>$id]);
//        return $this->redirect(['view','id'=>$prodid]);
//    }
    public function actionPrintstock()
    {
        if (Yii::$app->request->isPost) {
            $prod_id = Yii::$app->request->post('product_stocklist');
            $stock_type = Yii::$app->request->post('stock_type');
            if ($prod_id != '') {
                //$model = new \backend\models\Journal();
                if ($stock_type == 1) {
                    $paper_size = Pdf::FORMAT_A4;
                    $orient = Pdf::ORIENT_PORTRAIT;
                    $prodid = explode(',', $prod_id);

                    $modellist = \backend\models\Stockbalance::find()->where(['id' => $prodid])->all();

                    $pdf = new Pdf([
                        'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                        'format' => $paper_size,
                        // 'format' => [60, 30],//กำหนดขนาด
                        'orientation' => $orient,
                        'destination' => Pdf::DEST_BROWSER,
                        'content' => $this->renderPartial('_printstock', [
                            'list' => $modellist,
                        ]),
                        //'content' => "nira",
                        'cssFile' => '@backend/web/css/pdf.css',
                        // 'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
                        'options' => [
                            'title' => 'รายการจำนวนสินค้า',
                            'subject' => ''
                        ],
                        'methods' => [
                            'SetHeader' => ['รายการจำนวนสินค้า||Generated On: ' . date("r")],
                            'SetFooter' => ['|Page {PAGENO}|'],
                        ]
                    ]);
                    return $pdf->render();
                } else {

                }
            }
        }
    }

    public function actionAddvendorline()
    {
        return $this->renderPartial('_addvendor');
    }

    public function actionFindvendor()
    {
        // return Json::encode(['AX2012','AX2018']);
        $term = Yii::$app->request->post('query');
        $product = Product::find()->where(['LIKE', 'product_code', $term])->all();
        $lists = [];
        foreach ($product as $country) {
            $lists[] = [
                'id' => $country->id,
                'name' => $country->name,
                'code' => $country->product_code,
            ];
        }
        print_r($product);
        // return Json::encode($lists);
    }

    public function actionSearchitem()
    {
        $txt = \Yii::$app->request->post('txt');
        $list = [];
        if ($txt == '') {
            return Json::encode($list);
            //return 'no';
        } else {
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
//                return Json::encode($model);
//            }
            if ($txt == "*") {
                $model = \common\models\QueryProduct::find()
                    ->asArray()
                    ->all();
                return Json::encode($model);
            } else {
                $model = \common\models\QueryProduct::find()->where(['or', ['Like', 'engname', $txt], ['Like', 'name', $txt]])
                    ->orFilterWhere(['like', 'engname', $txt])
                    ->orFilterWhere(['like', 'name', $txt])
                    ->asArray()
                    ->all();
                return Json::encode($model);
            }
        }
    }

    public function actionGetphoto()
    {
        $id = \Yii::$app->request->post('product_id');
        $html = '';
        if ($id) {
            $model = \backend\models\Productimage::find()->where(['product_id' => $id])->one();
            $url = '../web/uploads/images/' . $model->name;
            if ($model) {
                $html .= '<img src="' . $url . '" width="100%">';
            }
        }
        echo $html;
    }

    public function actionImportthai()
    {
        $model = new \backend\models\Uploadfile();
        $qty_text = [];
       // if (Yii::$app->request->post()) {
            $uploaded = UploadedFile::getInstance($model, 'file');
//            if (!empty($uploaded)) {
//                $upfiles = time() . "." . $uploaded->getExtension();
//                if ($uploaded->saveAs('../web/uploads/files/' . $upfiles)) {
                    //echo "okk";return;
                    $myfile = '../web/uploads/files/import_thai.csv';
                    $file = fopen($myfile, "r");
                    fwrite($file, "\xEF\xBB\xBF");

                    setlocale(LC_ALL, 'th_TH.TIS-620');
                    $i = -1;
                    $res = 0;
                    $data = [];
                    while (($rowData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $i += 1;

                        $permit_date = null;
                        $inv_date = null;
                        $trans_date = null;
                        $kno_date = null;


                        if ($rowData[1] == '' || $i == 0) {
                            continue;
                        }

                        $prodcode = $rowData[1];
                        $thainame = $rowData[3];

                        $model = \backend\models\Product::find()->where(['product_code'=>$prodcode])->one();
                        if($model){
                            $model->description = $thainame;
                            $model->save();
                        }

                    }
                    fclose($file);
//                }
//            }
      //  }
    }
}
