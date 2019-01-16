<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Stockbalance;

/**
 * StockbalanceSearch represents the model behind the search form of `backend\models\Stockbalance`.
 */
class StockbalanceSearch extends Stockbalance
{
    public $globalSearch ,$productSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'warehouse_id', 'loc_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['qty'], 'number'],
            [['globalSearch','productSearch'],'string'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Stockbalance::find();

        $query->joinWith('product');
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
            'loc_id' => $this->loc_id,
            'qty' => $this->qty,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

       if($this->productSearch !=""){
           $query->orFilterWhere(['like','product.product_code',$this->productSearch])
               ->orFilterWhere(['like','product.engname',$this->productSearch])
               ->orFilterWhere(['like','product.name',$this->productSearch])
           ->orFilterWhere(['like','product.description',$this->productSearch]);
       }

        return $dataProvider;
    }
}
