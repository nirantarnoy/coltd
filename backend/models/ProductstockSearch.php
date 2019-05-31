<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Productstock;

/**
 * ProductstockSearch represents the model behind the search form of `backend\models\Productstock`.
 */
class ProductstockSearch extends Productstock
{
    public $globalSearch ,$productSearch,$warehouseSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',  'warehouse_id', 'in_qty', 'out_qty', 'sequence', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['invoice_no', 'invoice_date', 'transport_in_no', 'transport_in_date', 'permit_no', 'permit_date', 'kno_no_in', 'kno_in_date'], 'safe'],
            [['usd_rate', 'thb_amount'], 'number'],
            [['globalSearch','productSearch','warehouseSearch'],'string'],
            [['product_id'],'safe'],
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
        $query = Productstock::find();

        $query->joinWith('product');
        $query->joinWith('warehouse');
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
           // 'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
            'in_qty' => $this->in_qty,
            'out_qty' => $this->out_qty,
            'invoice_date' => $this->invoice_date,
            'transport_in_date' => $this->transport_in_date,
            'sequence' => $this->sequence,
            'permit_date' => $this->permit_date,
            'kno_in_date' => $this->kno_in_date,
            'usd_rate' => $this->usd_rate,
            'thb_amount' => $this->thb_amount,
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
            //$query->AndFilterWhere(['like','warehouse.name',$this->warehouseSearch]);
        }

        return $dataProvider;
    }
}
