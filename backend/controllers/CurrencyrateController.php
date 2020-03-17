<?php

namespace backend\controllers;

use Yii;
use backend\models\Currencyrate;
use backend\models\CurrencyrateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CurrencyrateController implements the CRUD actions for Currencyrate model.
 */
class CurrencyrateController extends Controller
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
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Currencyrate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new CurrencyrateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Currencyrate model.
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
     * Creates a new Currencyrate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Currencyrate();

        if ($model->load(Yii::$app->request->post())) {
            $model->from_date = date('Y/m/d',strtotime($model->from_date));
            $model->to_date = date('Y/m/d',strtotime($model->to_date));

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionCheckmonth(){
        $find_month = \Yii::$app->request->post('find_month');
        $find_type = \Yii::$app->request->post('find_type');
//       return $find_type;
        if($find_month !='' && $find_type !=''){
            $model = \backend\models\Currencyrate::find()->where(['MONTH(from_date)'=>(int)$find_month,'rate_type'=>$find_type])->one();
            if($model){
                echo 1;
            }else{
                echo 0;
            }
        }

    }

    /**
     * Updates an existing Currencyrate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->load(Yii::$app->request->post())){
            $fm_date = explode('/',$model->from_date);
            $f_date = '';
            if(count($fm_date)>0){
                $f_date = $fm_date[1].'/'.$fm_date[0].'/'.$fm_date[2];
            }
            $to_date = explode('/',$model->to_date);
            $t_date = '';
            if(count($to_date)>0){
                $t_date = $to_date[1].'/'.$to_date[0].'/'.$to_date[2];
            }

         //  echo $f_date.' and '.$t_date;return;

        $model->from_date = date('Y-m-d', strtotime($f_date));
        $model->to_date = date('Y-m-d', strtotime($t_date));


//        echo $model->from_currency;return;

        if ($model->save(false)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }


       }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Currencyrate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Currencyrate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Currencyrate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Currencyrate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
