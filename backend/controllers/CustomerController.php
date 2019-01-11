<?php

namespace backend\controllers;

use Yii;
use backend\models\Customer;
use backend\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\imagine\Image;


/**
 * CustomerController implements the CRUD actions for Custumer model.
 */
class CustomerController extends Controller
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
     * Lists all Custumer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Custumer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modelfile = \common\models\CustomerFile::find()->where(['party_id'=>$id,'party_type'=>2,'file_type'=>2])->all();
        $modeldoc = \common\models\CustomerFile::find()->where(['party_id'=>$id,'party_type'=>2,'file_type'=>3])->all();
        $modelseeme = \backend\models\Customerdetail::find()->where(['customer_id'=>$id,'line_type'=>3])->all();
        $modelitem = \backend\models\Customerdetail::find()->where(['customer_id'=>$id,'line_type'=>1])->all();
        $modelbucket = \backend\models\Customerdetail::find()->where(['customer_id'=>$id,'line_type'=>2])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelfile'=>$modelfile,
            'modeldoc'=>$modeldoc,
            'modelseeme'=>$modelseeme,
            'modelitem' => $modelitem,
            'modelbucket' => $modelbucket
        ]);
    }

    /**
     * Creates a new Custumer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();
        $model_address = new \backend\models\AddressBook();

        if ($model->load(Yii::$app->request->post()) && $model_address->load(Yii::$app->request->post())) {

            $model->customer_group_id = Yii::$app->request->post('customer_group');
            $model->zone_id = Yii::$app->request->post('zone_id');

            $district = Yii::$app->request->post('select_district');
            $city = Yii::$app->request->post('select_city');
            $province = Yii::$app->request->post('select_province');

            $delivery = Yii::$app->request->post('delivery_type');


            $item_check = substr(Yii::$app->request->post('select_item'),0,1);
            $item_last = '';
            if($item_check == ","){
                $item_last= substr(Yii::$app->request->post('select_item'),1,strlen(Yii::$app->request->post('select_item')));
            }else{
                $item_last = Yii::$app->request->post('select_item');
            }
            $item_list = explode(',',$item_last) ;
            $item_qty = Yii::$app->request->post('item_qty');

            $bucket_check = substr(Yii::$app->request->post('select_bucket'),0,1);
            $bucket_last = '';

            if($bucket_check == ","){
                $bucket_last= substr(Yii::$app->request->post('select_bucket'),1,strlen(Yii::$app->request->post('select_bucket')));
            }else{
                $bucket_last = Yii::$app->request->post('select_bucket');
            }

            $bucket_list = explode(',',$bucket_last) ;
            $bucket_qty = Yii::$app->request->post('bucket_qty');

            $uploadimage = UploadedFile::getInstancesByName('imagefile');
            $uploaddoc = UploadedFile::getInstancesByName('docfile');


            //print_r($bucket_list);return;
            $model->customer_group_id = Yii::$app->request->post('customer_group');
            $model->zone_id = Yii::$app->request->post('zone_id');
            $model->delivery_type = $delivery;
            if ($model->save()) {
                // insert address
                $model_address->status = 1;
                $model_address->party_id = $model->id;
                $model_address->district_id = $district;
                $model_address->city_id = $city;
                $model_address->province_id = $province;
                $model_address->party_type_id = 2;
                $model_address->save(false);

                if (!empty($uploadimage)) {
                    foreach ($uploadimage as $file) {
                        $file->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/' . $file);
                        Image::thumbnail(Yii::getAlias('@backend') . '/web/uploads/images/' . $file, 100, 70)
                            ->rotate(0)
                            ->save(Yii::getAlias('@backend') . '/web/uploads/thumbnail/' . $file, ['jpeg_quality' => 100]);


                        $modelfile = new \common\models\CustomerFile();
                        $modelfile->party_id = $model->id;
                        $modelfile->party_type = 2; //1 = คัดกรอง 2 = ลูกค้า
                        $modelfile->file_type = 2; // 2 = รูปภาพ
                        $modelfile->name = $file;
                        $modelfile->save(false);
                    }


                }
                if(!empty($uploaddoc)){
                    foreach($uploaddoc as $file){

                        $file->saveAs(Yii::getAlias('@backend') .'/web/uploads/documents/'.$file);

                        $modelfile = new \common\models\CustomerFile();
                        $modelfile->party_id = $model->id;
                        $modelfile->party_type = 2; //2 = คูกค้า
                        $modelfile->file_type = 3; // 2 = รูปภาพ 3 = เอกสาร
                        $modelfile->name = $file;
                        $modelfile->save(false);
                    }
                }
                if(count($item_list)>0 && count($item_qty)>0){
                    for($i=0;$i<=count($item_list)-1;$i++){
                        $detail = new \backend\models\Customerdetail();
                        $detail->customer_id = $model->id;
                        $detail->itemid = $item_list[$i];
                        $detail->qty = $item_qty[$i];
                        $detail->line_type = 1;
                        $detail->status = 1;
                        $detail->save();
                    }

                }
                if(count($bucket_list)>0 && count($bucket_qty)>0){
                    for($i=0;$i<=count($bucket_list)-1;$i++){

                        $detail = new \backend\models\Customerdetail();
                        $detail->customer_id = $model->id;
                        $detail->itemid = $bucket_list[$i];
                        $detail->qty = $bucket_qty[$i];
                        $detail->line_type = 2;
                        $detail->status = 1;
                        $detail->save();
                    }
                }

                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }

        }
        return $this->render('create', [
            'model' => $model,
            'model_address' => $model_address,
            'model_address_plant' => null,
        ]);
    }

    /**
     * Updates an existing Custumer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_address = new \backend\models\AddressBook();
         if ($model->load(Yii::$app->request->post())) {

                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }


        return $this->render('update', [
            'model' => $model,
            'model_address'=>$model_address,

        ]);
    }


    /**
     * Deletes an existing Custumer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $session = Yii::$app->session;
        $session->setFlash('msg','บันทึกรายการเรียบร้อย');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Custumer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Custumer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionDeletepic(){
        //$id = \Yii::$app->request->post("product_id");
        $picid = \Yii::$app->request->post("pic_id");
        if($picid){
            $model = \common\models\CustomerFile::find()->where(['id'=>$picid])->one();
            if($model){
                unlink(Yii::getAlias('@backend') .'/web/uploads/thumbnail/'.$model->name);
                unlink(Yii::getAlias('@backend') .'/web/uploads/images/'.$model->name);
                \common\models\CustomerFile::deleteAll(['id'=>$picid]);
            }

            return true;
        }
    }
    public function actionDeletefile(){
        //$id = \Yii::$app->request->post("product_id");
        $filename = trim(\Yii::$app->request->post("file_id"));
        $cusid = \Yii::$app->request->post("cus_id");
        if($filename){
           // return $cusid;
            $model = \common\models\CustomerFile::find()->where(['name'=>$filename,'party_id'=>$cusid,'party_type'=>2])->one();
            if($model){
                //return 100;
                unlink(Yii::getAlias('@backend') .'/web/uploads/documents/'.$filename);
                \common\models\CustomerFile::deleteAll(['party_id'=>$cusid,'name'=>$filename,'party_type'=>2]);
            }

            return true;
        }
    }
    public function actionPrintlongrentmaster($id){
        if($id) {
            $model = \backend\models\Custumer::find()->where(['id'=>$id])->one();
            if($model){
                $cus_address = \backend\models\AddressBook::findAddress($id);
                $pdf = new Pdf([

                    //'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                    //  'format' => [150,236], //manaul
                    'mode' => 's',
                    'format' => Pdf::FORMAT_A4,
                    'orientation' => Pdf::ORIENT_PORTRAIT,
                    'destination' => Pdf::DEST_BROWSER,
                    'content' => $this->renderPartial('_longrentmaster', [
                         'model'=>$model,
                         'cus_address'=>$cus_address,
                    ]),
                    //'content' => "nira",
                    //'defaultFont' => '@backend/web/fonts/config.php',
                    'cssFile' => '@backend/web/css/pdf.css',
                    //'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                    'options' => [
                        'title' => 'รายงานระหัสินค้า',
                        'subject' => ''
                    ],
                    'methods' => [
                        //  'SetHeader' => ['รายงานรหัสสินค้า||Generated On: ' . date("r")],
                        //  'SetFooter' => ['|Page {PAGENO}|'],
                        //'SetFooter'=>'niran',
                    ],

                ]);
                //return $this->redirect(['genbill']);
                return $pdf->render();
            }

        }
    }
    public function actionPrintshortrentmaster($id){
        if($id) {
            $model = \backend\models\Custumer::find()->where(['id'=>$id])->one();
            if($model){
                $cus_address = \backend\models\AddressBook::findAddress($id);
                $pdf = new Pdf([

                    //'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                    //  'format' => [150,236], //manaul
                    'mode' => 's',
                    'format' => Pdf::FORMAT_A4,
                    'orientation' => Pdf::ORIENT_PORTRAIT,
                    'destination' => Pdf::DEST_BROWSER,
                    'content' => $this->renderPartial('_shortrentmaster', [
                        'model'=>$model,
                        'cus_address'=>$cus_address,
                    ]),
                    //'content' => "nira",
                    //'defaultFont' => '@backend/web/fonts/config.php',
                    'cssFile' => '@backend/web/css/pdf.css',
                    //'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                    'options' => [
                        'title' => 'รายงานระหัสินค้า',
                        'subject' => ''
                    ],
                    'methods' => [
                        //  'SetHeader' => ['รายงานรหัสสินค้า||Generated On: ' . date("r")],
                        //  'SetFooter' => ['|Page {PAGENO}|'],
                        //'SetFooter'=>'niran',
                    ],

                ]);
                //return $this->redirect(['genbill']);
                return $pdf->render();
            }

        }
    }
}
