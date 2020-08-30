<?php

namespace backend\controllers;

use backend\models\PickinglineSearch;
use backend\models\QuerybalanceSearch;
use backend\models\QuerypickingSearch;
use backend\models\TransCalculate;
use Yii;
use backend\models\Sale;
use backend\models\SaleSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use backend\helpers\TransType;

/**
 * SaleController implements the CRUD actions for Sale model.
 */
class ReportController extends Controller
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
     * Lists all Sale models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('_balance');
    }

    public function actionBalance()
    {
        $searchModel = new QuerybalanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('_balance', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSale()
    {
        $from_date = '';
        $to_date = '';
        $qty = null;

        if (!empty(Yii::$app->request->queryParams['QuerypickingSearch'])) {
            $qty = Yii::$app->request->queryParams['QuerypickingSearch']['qty'];
            $find_date = explode('-', Yii::$app->request->queryParams['QuerypickingSearch']['picking_date']);
            if (count($find_date) == 2) {
                $from_date = $find_date[0];
                $to_date = $find_date[1];
            }
        }

//        $find_date = Yii::$app->request->get('picking_date');
        //  echo print_r(Yii::$app->request->queryParams['QuerypickingSearch']['picking_date']);return;
        $searchModel = new QuerypickingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['AND', ['>=', 'picking_date', $from_date], ['<=', 'picking_date', $to_date]]);
        if ($qty != null) {
            $dataProvider->query->andFilterWhere(['qty' => $qty]);
        }

        $dataProvider->setSort(['defaultOrder' => ['picking_date' => SORT_ASC]]);
        return $this->render('_sale', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInbound()
    {
        $from_date = '';
        $to_date = '';
        $qty = null;

        if (!empty(Yii::$app->request->queryParams['QueryinboundSearch'])) {
            $qty = Yii::$app->request->queryParams['QueryinboundSearch']['qty'];
            $find_date = explode('-', Yii::$app->request->queryParams['QueryinboundSearch']['invoice_date']);
            if (count($find_date) == 2) {
                $from_date = $find_date[0];
                $to_date = $find_date[1];
            }
        }

//        $find_date = Yii::$app->request->get('picking_date');
        //  echo print_r(Yii::$app->request->queryParams['QuerypickingSearch']['picking_date']);return;
        $searchModel = new \backend\models\QueryinboundSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['AND', ['>=', 'invoice_date', $from_date], ['<=', 'invoice_date', $to_date]]);
        if ($qty != null) {
            $dataProvider->query->andFilterWhere(['qty' => $qty]);
        }

        $dataProvider->setSort(['defaultOrder' => ['invoice_date' => SORT_ASC]]);
        return $this->render('_inbound', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShowpayment()
    {
        $no = \Yii::$app->request->post('invoice_no');
        $html = '';

        $model_chk = \backend\models\Inboundinv::find()->where(['invoice_no' => trim($no)])->one();
        if ($model_chk != null) {
            if ($model_chk->id > 0) {
                $model = \backend\models\Inboundpayment::find()->where(['inbound_id' => $model_chk->id])->all();
                $i = 0;
                if ($model != null) {
                    foreach ($model as $value) {
                        $i += 1;
                        $html .= '<tr>
                                <td>' . $i . '</td>
                                <td>' . $value->trans_date . '</td>
                                <td>' . $value->amount . '</td>
                                <td>' . $value->note . '</td>
                                <td>
                                    <a href="../web/uploads/slip/' . trim($value->slip) . '"
                                       target="_blank">' . $value->slip . '</a>
                                </td>
                                <td>
                                </td>
                                </tr>';
                    }
                }
            }
        }

        echo $html;
    }

    public function actionShowsalepayment()
    {
        $no = \Yii::$app->request->post('inv_no');
        $html = '';

        $model_chk = \backend\models\Querypicking::find()->where(['sale_no' => trim($no)])->one();
        if ($model_chk != null) {
            if ($model_chk->id > 0) {
                $model = \backend\models\Paymenttrans::find()->where(['sale_id' => $model_chk->id])->all();
                $i = 0;
                if ($model != null) {
                    foreach ($model as $value) {
                        $i += 1;
                        $html .= '<tr>
                                <td>' . $i . '</td>
                                <td>' . $value->trans_date . '</td>
                                <td>' . $value->amount . '</td>
                                <td>' . $value->note . '</td>
                                <td>
                                    <a href="../web/uploads/slip/' . trim($value->slip) . '"
                                       target="_blank">' . $value->slip . '</a>
                                </td>
                                <td>
                                </td>
                                </tr>';
                    }
                }
            }
        }

        echo $html;
    }

    public function actionArsummary()
    {

        $select_date = \Yii::$app->request->post('find_date');
        $selected_view = \Yii::$app->request->post('view_type');
        $from_date = '';
        $to_date = '';
        $qty = null;
        $selected_view_type = 0;

        if ($select_date != '') {
            $find_date = explode('ถึง', $select_date);
            if (count($find_date) == 2) {
                $from_date = $find_date[0];
                $to_date = $find_date[1];
            }
        }

        if($selected_view != ''){
            $selected_view_type = $selected_view;
        }

//        if ($from_date == null && $to_date == null) {
//            $searchModel = new \backend\models\QueryArsummarySearch();
//            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//            if($selected_view_type == 1){
//                $dataProvider->query->andFilterWhere(['>=','amount','total_amount']);
//            }else if($selected_view_type == 2){
//                $dataProvider->query->andFilterWhere(['<','amount','total_amount']);
//            }
//
////            if ($from_date != null && $to_date != null) {
////                $dataProvider->query->andFilterWhere(['AND', ['>=', 'require_date', strtotime($from_date)], ['<=', 'require_date', strtotime($to_date)]]);
////            }
////        $dataProvider->query->andFilterWhere(['AND',['>=','trans_date',$from_date],['<=','trans_date',$to_date]]);
////        if($qty != null){
////            $dataProvider->query->andFilterWhere(['amount'=>$qty]);
////        }
//
//            //   $dataProvider->setSort(['defaultOrder'=>['trans_date'=>SORT_ASC]]);
//            return $this->render('_arsummary', [
//                'dataProvider' => $dataProvider,
//                'from_date' => $from_date,
//                'to_date' => $to_date,
//                'selected_view_type' => $selected_view_type
//            ]);
//        } else {
            return $this->redirect(['report/showar', 'from_date' => $from_date, 'to_date' => $to_date,'selected_view_type'=>$selected_view_type]);
      //  }

    }

    public function actionShowar($from_date, $to_date, $selected_view_type)
    {
        if ($from_date != null && $to_date != null) {
            $searchModel = new \backend\models\QueryArsummarySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         //   $dataProvider->query->andFilterWhere(['AND', ['>=', 'require_date', strtotime($from_date)], ['<=', 'require_date', strtotime($to_date)]]);

            if($selected_view_type == 1){
                $dataProvider->query->andFilterWhere(['>=','amount','`total_amount`']);

            }else if($selected_view_type == 2){
                $dataProvider->query->andFilterWhere(['<','amount','`total_amount`']);
            }

            $dataProvider->query->andFilterWhere(['AND', ['>=', 'require_datex', strtotime($from_date)], ['<=', 'require_date', strtotime($to_date)]]);

            return $this->render('_arsummary', [
                'dataProvider' => $dataProvider,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'selected_view_type' =>$selected_view_type
            ]);
        }else{
            $searchModel = new \backend\models\QueryArsummarySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            if($selected_view_type == 1){
                $dataProvider->query->andFilterWhere(['>=','amount','`total_amount`']);
            }else if($selected_view_type == 2){
                $dataProvider->query->andFilterWhere(['<','amount','`total_amount`']);
            }
            return $this->render('_arsummary', [
                'dataProvider' => $dataProvider,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'selected_view_type' => $selected_view_type
            ]);

        }
    }

    public function actionApsummary()
    {
        $select_date = \Yii::$app->request->post('find_date');
        $from_date = '';
        $to_date = '';
        $qty = null;
        $selected_view = \Yii::$app->request->post('view_type');
        $selected_view_type = 0;

        if($selected_view != ''){
            $selected_view_type = $selected_view;
        }

        if ($select_date != '') {
            $find_date = explode('ถึง', $select_date);
            if (count($find_date) == 2) {
                $from_date = $find_date[0];
                $to_date = $find_date[1];
            }
        }

        // echo 'niran';return;
//        if ($from_date == null && $to_date == null) {
//            $searchModel = new \backend\models\QueryApsummarySearch();
//            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//            $dataProvider->query->andFilterWhere(['AND', ['>=', 'invoice_date', $from_date], ['<=', 'invoice_date', $to_date]]);
////        if($qty != null){
////            $dataProvider->query->andFilterWhere(['amount'=>$qty]);
////        }
//
//            //   $dataProvider->setSort(['defaultOrder'=>['trans_date'=>SORT_ASC]]);
//            return $this->render('_apsummary', [
//                'dataProvider' => $dataProvider,
//                'from_date' => $from_date,
//                'to_date' => $to_date
//            ]);
//        } else {
            //echo "ok";return;
            return $this->redirect(['report/showap', 'from_date' => $from_date, 'to_date' => $to_date, 'selected_view_type'=>$selected_view_type]);
 //       }
    }

    public function actionShowap($from_date, $to_date, $selected_view_type)
    {
        if ($from_date != null && $to_date != null) {

            $s_date = null;
            $n_date = null;
            $a1 = null;
            $b1 = null;


            $a = explode('-', trim($from_date));
            $a1 = $a[2] . '-' . $a[1] . '-' . $a[0];


            $b = explode('-', trim($to_date));
            $b1 = $b[2] . '-' . $b[1] . '-' . $b[0];


            $s_date = date('Y-m-d', strtotime($a1));
            $n_date = date('Y-m-d', strtotime($b1));

            $searchModel = new \backend\models\QueryApsummarySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andFilterWhere(['AND', ['>=', 'invoice_date', $s_date], ['<=', 'invoice_date', $n_date]]);

            if($selected_view_type == 1){
                $dataProvider->query->andFilterWhere(['<=','amount','total_amount']);
            }else if($selected_view_type == 2){
                $dataProvider->query->andFilterWhere(['>','amount','total_amount']);
            }

            return $this->render('_apsummary', [
                'dataProvider' => $dataProvider,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'selected_view_type' => $selected_view_type
            ]);
        }else{
            $searchModel = new \backend\models\QueryApsummarySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            if($selected_view_type == 1){
                $dataProvider->query->andFilterWhere(['<=','amount','total_amount']);
            }else if($selected_view_type == 2){
                $dataProvider->query->andFilterWhere(['>','amount','total_amount']);
            }

            return $this->render('_apsummary', [
                'dataProvider' => $dataProvider,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'selected_view_type' => $selected_view_type
            ]);
        }
    }
}
