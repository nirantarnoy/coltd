<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Addressbook;

/**
 * AddressbookSearch represents the model behind the search form of `backend\models\Addressbook`.
 */
class AddressbookSearch extends Addressbook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'address_type_id', 'party_type_id', 'party_id', 'district_id', 'city_id', 'province_id', 'zipcode', 'is_primary', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['address', 'street'], 'safe'],
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
        $query = Addressbook::find();

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
            'address_type_id' => $this->address_type_id,
            'party_type_id' => $this->party_type_id,
            'party_id' => $this->party_id,
            'district_id' => $this->district_id,
            'city_id' => $this->city_id,
            'province_id' => $this->province_id,
            'zipcode' => $this->zipcode,
            'is_primary' => $this->is_primary,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'street', $this->street]);

        return $dataProvider;
    }
}
