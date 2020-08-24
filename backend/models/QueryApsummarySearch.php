<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Querybalance;

/**
 * EmployeeSearch represents the model behind the search form of `backend\models\Employee`.
 */
class QueryApsummarySearch extends QueryApsummary
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['invoice_date'], 'safe'],
            [['total_amount', 'amount'], 'number'],
            [['invoice_no', 'name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = QueryApsummary::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        // grid filtering conditions
        $query->andFilterWhere([
            //'trans_date' => $this->trans_date,
            'invoice_date' => $this->invoice_date,
            'invoice_no' => $this->invoice_no,
            'name' => $this->name,
            'total_amount' => $this->total_amount,
            'amount' => $this->amount,

        ]);
//
////        if($this->globalSearch != ''){
//        $query->orFilterWhere(['like','engname',$this->engname])
//            ->orFilterWhere(['like','name',$this->name]);
////        }

        return $dataProvider;
    }
}
