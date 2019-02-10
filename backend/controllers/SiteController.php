<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $from_date = '';
        $to_date = '';
        $all_sale_qty = 0;
        $all_sale_amount = 0;
        $all_rec_qty = 0;
        $all_rec_amount = 0;
        $find_date = null;
        if(Yii::$app->request->isGet){
            $find_date = explode(' ถึง ',Yii::$app->request->get('date_select'));
        }else{
        }
        if(count($find_date)>0 && Yii::$app->request->get('date_select') != null) {
            $from_date = $find_date[0];
            $to_date = $find_date[1];

            $all_sale_qty = \backend\models\Saleline::find()->where(['BETWEEN','created_at',strtotime($from_date),strtotime($to_date)])->sum('qty');
            $all_sale_amount = \backend\models\Saleline::find()->where(['BETWEEN','created_at',strtotime($from_date),strtotime($to_date)])->sum('qty * price');
            $all_rec_qty = \common\models\QueryTrans::find()->where(['BETWEEN','created_at',strtotime($from_date),strtotime($to_date)])
                                                               ->andFilterWhere(['stock_type'=>0])->sum('qty');
            $all_rec_amount = \common\models\QueryTrans::find()->where(['BETWEEN','created_at',strtotime($from_date),strtotime($to_date)])
                                                                ->andFilterWhere(['stock_type'=>0])->sum('qty * cost');


        }


        return $this->render('_dashboard',[
            'from_date' => $from_date,
            'to_date' => $to_date,
            'all_sale_qty' =>$all_sale_qty,
            'all_sale_amount' =>$all_sale_amount,
            'all_rec_qty' =>$all_rec_qty,
            'all_rec_amount' =>$all_rec_amount,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = false;
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('_login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
