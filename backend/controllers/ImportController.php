<?php

namespace backend\controllers;

use Yii;
use backend\models\Import;
use backend\models\ImportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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
            $model->invoice_date = date('Y/m/d',strtotime($model->invoice_date));
            if($model->save(false)){
                if(!empty($uploaded)){
                    $uploaded->saveAs(Yii::getAlias('@backend') .'/web/uploads/files/'.$uploaded);

                    $importfile = new \backend\models\Importfile();
                    $importfile->import_id = $model->id;
                    $importfile->filename = $uploaded->name;
                    $importfile->save(false);
                  }

                return $this->redirect(['view', 'id' => $model->id]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $uploaded = UploadedFile::getInstance($modelfile,'file');
            $model->invoice_date = date('Y/m/d',strtotime($model->invoice_date));
            if($model->save(false)){
                if(!empty($uploaded)){
                    $uploaded->saveAs(Yii::getAlias('@backend') .'/web/uploads/files/'.$uploaded);
                    $importfile = new \backend\models\Importfile();
                    $importfile->import_id = $model->id;
                    $importfile->filename = $uploaded->name;
                    $importfile->save();
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelfile' => $modelfile,
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
        $this->findModel($id)->delete();

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
}
