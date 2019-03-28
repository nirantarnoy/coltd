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
                        'actions' => ['logout', 'index','resetpassword'],
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
        $query = null;
        $query2 = null;
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

            $sql = "SELECT engname,SUM(qty*price) as total FROM query_picking WHERE created_at BETWEEN ".strtotime($from_date)." AND ".strtotime($to_date)." group by engname";
            $query = \Yii::$app->db->createCommand($sql)->queryAll();

            $sql2 = "SELECT product_group,SUM(qty*price) as total FROM query_picking WHERE created_at BETWEEN ".strtotime($from_date)." AND ".strtotime($to_date)." group by product_group";
            $query2 = \Yii::$app->db->createCommand($sql2)->queryAll();
        }

           $name = [];
           $data = [];
           $data2 = [];

        if(count($query) || $query != null){
               for($i=0;$i<=count($query)-1;$i++){
                   array_push($name,$query[$i]['engname']);
                   array_push($data,(float)$query[$i]['total']);
               }
           }
        if(count($query2) || $query2 != null){
            for($i=0;$i<=count($query2)-1;$i++){
                array_push($data2,['name'=>$query2[$i]['product_group'],'y'=>(float)$query2[$i]['total']]);
            }
        }

        return $this->render('_dashboard',[
            'from_date' => $from_date,
            'to_date' => $to_date,
            'all_sale_qty' =>$all_sale_qty,
            'all_sale_amount' =>$all_sale_amount,
            'all_rec_qty' =>$all_rec_qty,
            'all_rec_amount' =>$all_rec_amount,
            'name' => $name,
            'data' => $data,
            'data2' => $data2,
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
    public function actionResetpassword(){
        $model=new \backend\models\Resetform();
        if($model->load(Yii::$app->request->post())){

            $model_user = \backend\models\User::find()->where(['id'=>Yii::$app->user->id])->one();
            if($model_user->validatePassword($model->oldpw)){
                $model_user->setPassword($model->confirmpw);
                $model_user->save();
                return $this->redirect(['site/index']);
            }else{
                $session = Yii::$app->session;
                $session->setFlash('msg_err','รหัสผ่านเดิมไม่ถูกต้อง');
            }

        }
        return $this->render('_setpassword',[
            'model'=>$model
        ]);
    }
}
