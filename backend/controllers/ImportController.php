<?php

namespace backend\controllers;

use Yii;
use backend\models\Import;
use backend\models\ImportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\Product;
use backend\models\Importfile;
use backend\models\Importline;

/**
 * ImportController implements the CRUD actions for Import model.
 */
class ImportController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Import models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new ImportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Import model.
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
     * Creates a new Import model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Import();
        $modelfile = new \backend\models\Modelfile();

        if ($model->load(Yii::$app->request->post())) {
            $uploaded = UploadedFile::getInstance($modelfile,'file');

            $productid = Yii::$app->request->post('product_id');
            $pack1 = Yii::$app->request->post('product_pack1');
            $pack2 = Yii::$app->request->post('product_pack2');
            $qty = Yii::$app->request->post('line_qty');
            $packing = Yii::$app->request->post('line_packing');
            $price_per = Yii::$app->request->post('line_price_per');
            $total_amount = Yii::$app->request->post('line_total_amount');
            $bottle_qty = Yii::$app->request->post('line_bottle_qty');
            $litre = Yii::$app->request->post('line_litre');
            $net = Yii::$app->request->post('line_net');
            $gross = Yii::$app->request->post('line_gross');
            $transport_in_no = Yii::$app->request->post('line_transport_in_no');
            $linenum = Yii::$app->request->post('line_num');
            $geo = Yii::$app->request->post('line_geo');
            $origin = Yii::$app->request->post('line_origin');
            $excise_no = Yii::$app->request->post('line_excise_no');
            $excise_date = Yii::$app->request->post('line_excise_date');
            $kno_no = Yii::$app->request->post('line_kno_no');
            $kno_date = Yii::$app->request->post('line_kno_date');
            $permit_no = Yii::$app->request->post('line_permit_no');
            $permit_date = Yii::$app->request->post('line_permit_date');

           // print_r($productid);return;


            $model->invoice_date = date('Y/m/d',strtotime($model->invoice_date));
            if($model->save(false)){
                if(!empty($uploaded)){
                    $uploaded->saveAs(Yii::getAlias('@backend') .'/web/uploads/files/'.$uploaded);

                    $importfile = new \backend\models\Importfile();
                    $importfile->import_id = $model->id;
                    $importfile->filename = $uploaded->name;
                    $importfile->save(false);
                  }
                if(count($productid)>0){
                    for($i=0;$i<=count($productid)-1;$i++){
                        $modelline = new \backend\models\Importline();
                        $modelline->import_id = $model->id;
                        $modelline->product_id = $productid[$i];
                        $modelline->price_pack1 = $pack1[$i];
                        $modelline->price_pack2 = $pack2[$i];
                        $modelline->qty = $qty[$i];
                        $modelline->product_packing = $packing[$i];
                        $modelline->price_per = $price_per[$i];
                        $modelline->total_price = $total_amount[$i] ;
                        $modelline->total_qty = $total_amount[$i];
                        $modelline->weight_litre = $litre[$i];
                        $modelline->netweight = $net[$i];
                        $modelline->grossweight = $gross[$i];
                        $modelline->transport_in_no = $transport_in_no[$i];
                        $modelline->line_num = $linenum[$i];
                        $modelline->position = $geo[$i];
                        $modelline->origin = $origin[$i];
                        $modelline->excise_no = $excise_no[$i];
                        $modelline->excise_date = $excise_date[$i];
                        $modelline->permit_no = $permit_no[$i];
                        $modelline->permit_date = $permit_date[$i];

                        $modelline->save();
                    }
                }
                $session = Yii::$app->session;
                $session->setFlash('msg','ดำเนินการเรียบร้อย');
                return $this->redirect(['index']);
                //return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'modelfile' => $modelfile
        ]);
    }

    /**
     * Updates an existing Import model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelfile = new \backend\models\Modelfile();
        $modelline = Importline::find()->where(['import_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $uploaded = UploadedFile::getInstance($modelfile,'file');

            $productid = Yii::$app->request->post('product_id');
            $pack1 = Yii::$app->request->post('product_pack1');
            $pack2 = Yii::$app->request->post('product_pack2');
            $qty = Yii::$app->request->post('line_qty');
            $packing = Yii::$app->request->post('line_packing');
            $price_per = Yii::$app->request->post('line_price_per');
            $total_amount = Yii::$app->request->post('line_total_amount');
            $bottle_qty = Yii::$app->request->post('line_bottle_qty');
            $litre = Yii::$app->request->post('line_litre');
            $net = Yii::$app->request->post('line_net');
            $gross = Yii::$app->request->post('line_gross');
            $transport_in_no = Yii::$app->request->post('line_transport_in_no');
            $linenum = Yii::$app->request->post('line_num');
            $geo = Yii::$app->request->post('line_geo');
            $origin = Yii::$app->request->post('line_origin');
            $excise_no = Yii::$app->request->post('line_excise_no');
            $excise_date = Yii::$app->request->post('line_excise_date');
            $kno_no = Yii::$app->request->post('line_kno_no');
            $kno_date = Yii::$app->request->post('line_kno_date');
            $permit_no = Yii::$app->request->post('line_permit_no');
            $permit_date = Yii::$app->request->post('line_permit_date');
            $recid = Yii::$app->request->post('recid');


            $model->invoice_date = date('Y/m/d',strtotime($model->invoice_date));
            if($model->save(false)){
                if(!empty($uploaded)){
                    $uploaded->saveAs(Yii::getAlias('@backend') .'/web/uploads/files/'.$uploaded);
                    $importfile = new \backend\models\Importfile();
                    $importfile->import_id = $model->id;
                    $importfile->filename = $uploaded->name;
                    $importfile->save();
                }
                if(count($productid)>0){
                    for($i=0;$i<=count($productid)-1;$i++){
                        $modelcheck = \backend\models\Importline::find()->where(['id'=>$recid])->one();
                        if($modelcheck){
                            $modelcheck->product_id = $productid[$i];
                            $modelcheck->price_pack1 = $pack1[$i];
                            $modelcheck->price_pack2 = $pack2[$i];
                            $modelcheck->qty = $qty[$i];
                            $modelcheck->product_packing = $packing[$i];
                            $modelcheck->price_per = $price_per[$i];
                            $modelcheck->total_price = $total_amount[$i] ;
                            $modelcheck->total_qty = $total_amount[$i];
                            $modelcheck->weight_litre = $litre[$i];
                            $modelcheck->netweight = $net[$i];
                            $modelcheck->grossweight = $gross[$i];
                            $modelcheck->transport_in_no = $transport_in_no[$i];
                            $modelcheck->line_num = $linenum[$i];
                            $modelcheck->position = $geo[$i];
                            $modelcheck->origin = $origin[$i];
                            $modelcheck->excise_no = $excise_no[$i];
                            $modelcheck->excise_date = $excise_date[$i];
                            $modelcheck->permit_no = $permit_no[$i];
                            $modelcheck->permit_date = $permit_date[$i];
                            $modelcheck->kno = $kno_no[$i];
                            $modelcheck->kno_date = $kno_date[$i];

                            $modelcheck->save();
                        }else{
                            $modelline = new \backend\models\Importline();
                            $modelline->import_id = $id;
                            $modelline->product_id = $productid[$i];
                            $modelline->price_pack1 = $pack1[$i];
                            $modelline->price_pack2 = $pack2[$i];
                            $modelline->qty = $qty[$i];
                            $modelline->product_packing = $packing[$i];
                            $modelline->price_per = $price_per[$i];
                            $modelline->total_price = $total_amount[$i] ;
                            $modelline->total_qty = $total_amount[$i];
                            $modelline->weight_litre = $litre[$i];
                            $modelline->netweight = $net[$i];
                            $modelline->grossweight = $gross[$i];
                            $modelline->transport_in_no = $transport_in_no[$i];
                            $modelline->line_num = $linenum[$i];
                            $modelline->position = $geo[$i];
                            $modelline->origin = $origin[$i];
                            $modelline->excise_no = $excise_no[$i];
                            $modelline->excise_date = $excise_date[$i];
                            $modelline->permit_no = $permit_no[$i];
                            $modelline->permit_date = $permit_date[$i];
                            $modelcheck->kno = $kno_no[$i];
                            $modelcheck->kno_date = $kno_date[$i];

                            $modelline->save();
                        }

                    }
                }
                $session = Yii::$app->session;
                $session->setFlash('msg','ดำเนินการเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelfile' => $modelfile,
            'modelline'=> $modelline,
        ]);
    }

    /**
     * Deletes an existing Import model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        \backend\models\Importfile::deleteAll(['import_id'=>$id]);
            $this->findModel($id)->delete();
        $session = Yii::$app->session;
        $session->setFlash('msg','ดำเนินการเรียบร้อย');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Import model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Import the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Import::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionExport($id){
        $type="xsl";
       // $id = Yii::$app->request->get('id');
        if($id){
            //return $id;
            $contenttype = "";
            $fileName = "";

            if($type == 'xsl'){
                $contenttype = "application/x-msexcel";
                $fileName="export_import.xls";
            }
//            if($type == 'csv'){
//                $contenttype = "application/csv";
//                $fileName="export_import.csv";
//            }

            $model = \backend\models\Importline::find()->all();

            header('Content-Encoding: UTF-8');
            header("Content-Type: ".$contenttype." ; name=\"$fileName\" ;charset=utf-8");
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 0");


            // print "\xEF\xBB\xBF";


            $model = Product::find()->all();
            if($model){

                foreach($model as $data){
                   // $cat = \backend\models\Productcat::findGroupname($data->category_id);
                   // $unit = \backend\models\Unit::findUnitname($data->unit_id);
                    echo "
                        <tr>
                            <td>#</td>
                            <td>รายการ</td>
                            <td>ราคา ลัง(USD)</td>
                            <td>ราคา ลัง(BAHT)</td>
                            <td>จำนวน</td>
                            <td>PACKING</td>
                            <td>ราคา/ขวด</td>
                            <td>ราคารวม</td>
                            <td>จำนวนขวด</td>
                            <td>น้ำหนักลิตร</td>
                            <td>น้ำหนัก</td>
                            <td>น้ำหนักรวมหีบห่อ</td>
                            <td>เลขที่ใบขนขาเข้า</td>
                            <td>รายการที่</td>
                            <td>พิกัด</td>
                            <td>ประเทศต้นกำเนิด</td>
                            <td>รหัสสินค้าสรรพสามิต</td>
                            <td>วันที่ (ค.ส)</td>
                            <td>กนอ</td>
                            <td>วันที่</td>
                            <td>ใบอนุญาต</td>
                            <td>วันที่</td>
                         </tr>
                    ";
                }
                echo "</table>";
            }

            if($model){
                $i=0;
                foreach($model as $data){
                    $i+=1;
                    // $cat = \backend\models\Productcat::findGroupname($data->category_id);
                    // $unit = \backend\models\Unit::findUnitname($data->unit_id);
                    echo "
                        <tr>
                            <td>".$i."</td>
                            <td>".$data->product_id."</td>
                            <td>".$data->price_pack1."</td>
                            <td>".$data->price_pack2."</td>
                            <td>".$data->qty."</td>
                            <td>".$data->product_packing."</td>
                            <td>".$data->price_per."</td>
                            <td>".$data->total_price."</td>
                            <td>".$data->total_qty."</td>
                            <td>".$data->weight_litre."</td>
                            <td>".$data->netweight."</td>
                            <td>".$data->grossweight."</td>
                            <td>".$data->transport_in_no."</td>
                            <td>".$data->line_num."</td>
                            <td>".$data->position."</td>
                            <td>".$data->origin."</td>
                            <td>".$data->exsice_no."</td>
                            <td>".$data->excise_date."</td>
                            <td>".$data->kno."</td>
                            <td>".$data->kno_date."</td>
                            <td>".$data->permit_no."</td>
                            <td>".$data->permit_date."</td>
                         </tr>
                    ";
                }
                echo "</table>";
            }

        }
    }

}
