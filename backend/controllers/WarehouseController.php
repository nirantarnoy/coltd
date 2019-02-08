<?php

namespace backend\controllers;

use Yii;
use backend\models\Warehouse;
use backend\models\WarehouseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * WarehouseController implements the CRUD actions for Warehouse model.
 */
class WarehouseController extends Controller
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
            'access'=>[
                'class'=>AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException('คุณไม่ได้รับอนุญาติให้เข้าใช้งาน!');
                },
                'rules'=>[
                    [
                        'allow'=>true,
                        'roles'=>['@'],
                        'matchCallback'=>function($rule,$action){
                            $currentRoute = Yii::$app->controller->getRoute();
                            if(Yii::$app->user->can($currentRoute)){
                                return true;
                            }
                        }
                    ]
                ]
            ]
//            'access'=>[
//
//                'class'=>AccessControl::className(),
//                'rules'=>[
//                        [
//                            'allow'=>true,
//                            'actions'=>['delete'],
//                            'roles'=>['SystemAdmin']
//                        ],
//                        [
//                            'allow'=>true,
//                            'actions'=>['index','view'],
//                            'roles'=>['ManageInventory']
//                        ],
//                        [
//                            'allow'=>true,
//                            'actions'=>['create','update'],
//                            'roles'=>['ManageInventory'],
//                            // 'matchCallback'=> function($rule,$action){
//                            //     $model = $this->findModel(Yii::$app->request->get('id'));
//                            //     if(\Yii::$app->user->can('UpdateOwner',['model'=>$model])){
//                            //         return true;
//                            //     }
//                            // }
//                        ]
//                    ]
//                ]
        ];
    }

    /**
     * Lists all Warehouse models.
     * @return mixed
     */

    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new WarehouseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
             'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Warehouse model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $movementSearch = new \backend\models\MovementSearch();
        $movementDp = $movementSearch->search(Yii::$app->request->queryParams);
        $movementDp->pagination->pageSize = 10;
        $movementDp->query->andFilterWhere(['to_wh'=>$id])
                          ->andFilterWhere(['trans_type'=>\backend\helpers\RunnoTitle::RUNN0_PDR]);

        $allqty =0;
        $model = $movementDp->getModels();
        foreach($model as $val){
            $allqty = $allqty + $val->qty;
        }


        $stock_by_warehouse = \backend\models\Stockbalance::find()->where(['warehouse_id'=>$id])->sum('qty');
        $amount_by_warehouse = \backend\models\Stockbalance::find()->where(['warehouse_id'=>$id])->sum('qty * 10');

        return $this->render('view', [
            'model' => $this->findModel($id),
            'movementSearch'=>$movementSearch,
            'movementDp' => $movementDp,
            'allqty' => $stock_by_warehouse,
            'allamount' => $amount_by_warehouse,
        ]);
    }

    /**
     * Creates a new Warehouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Warehouse();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Warehouse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $this->setDefault($id);
                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model,]);


    }

    /**
     * Deletes an existing Warehouse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

            $session = Yii::$app->session;
            $session->setFlash('msg','บันทึกรายการเรียบร้อย');
            return $this->redirect(['index']);

    }

    /**
     * Finds the Warehouse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Warehouse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Warehouse::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function setDefault($id){
        $model = Warehouse::find()->all();
        if($model){
            foreach($model as $data){
                $modelupdate = Warehouse::find()->where(['id'=>$data->id])->one();
                $modelupdate->is_primary = 0;
                $modelupdate->save(false);
            }
            $modelupdate = Warehouse::find()->where(['id'=>$id])->one();
            $modelupdate->is_primary = 1;
            $modelupdate->save(false);
        }
        return true;
    }
}
