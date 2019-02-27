<?php

namespace backend\controllers;

use Yii;
use backend\models\Plant;
use backend\models\PlantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;

use \backend\models\AddressBook;
/**
 * PlantController implements the CRUD actions for Plant model.
 */
class PlantController extends Controller
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
                    'delete' => ['POST'],
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
////                        'actions'=>['index','create','update','delete','showcity','showdistrict','showzipcode'],
////                        'roles'=>['Manage Plant'],
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
//            'access'=>[
//                'class'=> AccessControl::className(),
//                'rules'=>[
//                    [
//                        'allow'=>true,
//                        'actions'=>['index','create','view','update','delete','showcity','showdistrict','showzipcode','addbank'],
//                        'roles'=>['SystemAdmin']
//                    ],
//                    [
//                        'allow'=>true,
//                        'actions'=>['index'],
//                        'roles'=>['ManageInventory']
//                    ]
//                ]
//            ]
        ];
    }

    /**
     * Lists all Plant models.
     * @return mixed
     */

    public function actionIndex()
    {
        $modelx = Plant::find()->one();
        $model_address = new \backend\models\Addressbook();
        if(count($modelx)>0){
            return $this->redirect(['update','id'=>$modelx->id]);
        }
        $model = new Plant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_address'=> $model_address,
                'model_address_plant'=>null,
                //'model_bankaccount' => $model_bankaccount,
            ]);
        }
        // $searchModel = new PlantSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);

    }

    /**
     * Displays a single Plant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Plant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Plant();
        $model_address_plant = \backend\models\Addressbook::find()->where(['party_type_id'=>-1])->one();
        $model_address = new AddressBook();
        if ($model->load(Yii::$app->request->post())&& $model_address->load(Yii::$app->request->post())) {
            $uploaded = UploadedFile::getInstance($model, 'logo');
            if(!empty($uploaded)){
                $upfiles = time() . "." . $uploaded->getExtension();
                 //if ($uploaded->saveAs('../uploads/products/' . $upfiles)) {
                if ($uploaded->saveAs('../web/uploads/logo/' . $upfiles)) {
                    $model->logo = $upfiles;
                }
            }
            if($model->save()){
                $model_address->save(false);
                  $session = Yii::$app->session;
                  $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['update','id'=>$model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'model_address' => $model_address,
            'model_address_plant' => $model_address_plant,
        ]);
    }

    /**
     * Updates an existing Plant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_address = new \backend\models\Addressbook()
        $model_address_plant = \backend\models\Addressbook::find()->where(['party_id'=>$id,'party_type_id'=>1])->one();
        //$model_bankdata = \backend\models\Bankaccount::find()->where(['party_id'=>$id,'party_type_id'=>1])->all();

        if ($model->load(Yii::$app->request->post()) && $model_address->load(Yii::$app->request->post())) {

             $bankid = Yii::$app->request->post('bank_id');
             $typeid = Yii::$app->request->post('account_type');
             $bankname = Yii::$app->request->post('bank_name');
             $accountno = Yii::$app->request->post('account_no');
             $accountname = Yii::$app->request->post('account_name');
             $oldlogo = Yii::$app->request->post('old_logo');
             $brance = Yii::$app->request->post('brance');

             //$has_edit = Yii::$app->request->post('has_edit');

             $oldlogo = Yii::$app->request->post('old_logo');
                $uploaded = UploadedFile::getInstance($model, 'logo');
                    if(!empty($uploaded)){
                        $upfiles = time() . "." . $uploaded->getExtension();
                        if ($uploaded->saveAs('../web/uploads/logo/' . $upfiles)) {
                                   $model->logo = $upfiles;
                        }
                    }else{
                        $model->logo = $oldlogo;
                    }


            //print_r($accountno);return;
            if($model->save()){

               if(count($bankid)>0){
                for($i=0;$i<=count($bankid)-1;$i++){

                   $modelcheck = \backend\models\Bankaccount::find()->where(['party_id'=>$id,'party_type_id'=>1,'account_no'=>$accountno[$i]])->one();
                   if($modelcheck){

                        $modelcheck->account_name = $accountname[$i];
                        $modelcheck->account_no = $accountno[$i];
                        $modelcheck->bank_id = $bankid[$i];
                        $modelcheck->save(false);

                   }else{
                        $model_account = new \backend\models\Bankaccount();
                        $model_account->party_id = $id;
                        $model_account->party_type_id = $id;
                        $model_account->account_type_id = $typeid[$i];
                        $model_account->account_name = $accountname[$i];
                        $model_account->account_no = $accountno[$i];
                        $model_account->bank_id = $bankid[$i];
                        $model_account->save(false);
                   }

                }

               // print_r($accountno);return;

               // \backend\models\BankAccount::deleteAll(['AND',['party_id'=>$id,'party_type_id'=>1],['NOT IN','account_no',$accountno]]);
                // $x = \backend\models\BankAccount::find()->where(['AND',['party_id'=>$id,'party_type_id'=>1],['NOT IN','account_no',$accountno]])->count();

                // return $x;

               }

               if(count($model_address_plant) > 0){
                    $model_address_plant->load(Yii::$app->request->post());
                    $model_address_plant->save();
               }else{
                    $model_address->party_type_id = 1; // 1 = plant
                    $model_address->party_id = $id;
                    $model_address->save(false);
               }
                 $session = Yii::$app->session;
                 $session->setFlash('msg','บันทึกรายการเรียบร้อย');
               return $this->redirect(['update','id'=>$id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
            'model_address' => $model_address,
            'model_address_plant' => $model_address_plant,
           // 'model_bankdata' => $model_bankdata,
        ]);
    }

    /**
     * Deletes an existing Plant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Plant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plant::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionShowcity($id){
      $model = \common\models\Amphur::find()->where(['PROVINCE_ID' => $id])->all();

      if (count($model) > 0) {
          foreach ($model as $value) {

              echo "<option value='" . $value->AMPHUR_ID . "'>$value->AMPHUR_NAME</option>";

          }
      } else {
          echo "<option>-</option>";
      }
    }
    public function actionShowdistrict($id){
      $model = \common\models\District::find()->where(['AMPHUR_ID' => $id])->all();

      if (count($model) > 0) {
          foreach ($model as $value) {

              echo "<option value='" . $value->DISTRICT_ID . "'>$value->DISTRICT_NAME</option>";

          }
      } else {
          echo "<option>-</option>";
      }
    }
    public function actionShowzipcode($id){
      $model = \common\models\Amphur::find()->where(['AMPHUR_ID' => $id])->one();

      if (count($model) > 0) {
          echo $model->POSTCODE;
      } else {
          echo "";
      }
    }
    public function actionAddbank(){
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post('id');
            $bank_name = Yii::$app->request->post('txt');
            $account_no = Yii::$app->request->post('account');
            $account_name = Yii::$app->request->post('account_name');
            $brance = Yii::$app->request->post('brance');
            $account_type = Yii::$app->request->post('account_type');
            $desc = Yii::$app->request->post('desc');
            //return $id;
            if($id){
               // return $desc;
                $data = [];
                $data['id'] = $id;
                $data['bank_name'] = $bank_name;
                $data['account_no'] = $account_no;
                $data['account_name'] = $account_name;
                $data['brance'] = $brance;
                $data['account_type'] = $account_type;
                $data['description'] = $desc;

                return $this->renderPartial("_addbank",['data'=>$data]);
            }else{
                return;
            }
        }
       // $data = Yii::$app->request->post("data");

    }
}
