<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Product;

/**
 * ProductSearch represents the model behind the search form of `backend\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'product_type_id', 'unit_id', 'is_hold', 'has_variant', 'bom_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['product_code', 'name', 'description', 'barcode', 'photo'], 'safe'],
            [['min_stock', 'max_stock', 'cost', 'price'], 'number'],
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
        $query = Product::find();

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
            'category_id' => $this->category_id,
            'product_type_id' => $this->product_type_id,
            'unit_id' => $this->unit_id,
            'min_stock' => $this->min_stock,
            'max_stock' => $this->max_stock,
            'is_hold' => $this->is_hold,
            'has_variant' => $this->has_variant,
            'bom_type' => $this->bom_type,
            'cost' => $this->cost,
            'price' => $this->price,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'product_code', $this->product_code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}
