<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Querybalance;

/**
 * EmployeeSearch represents the model behind the search form of `backend\models\Employee`.
 */
class QuerybalanceSearch extends Querybalance
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'unit_id', 'category_id', 'product_type_id', 'status', 'journal_id', 'stock_type', 'unit_factor'], 'integer'],
            [[ 'qty', 'volumn', 'volumn_content', 'netweight', 'grossweight'], 'number'],
            [['product_code', 'name', 'description', 'journal_no', 'engname', 'origin'], 'string', 'max' => 255],
            [['globalSearch'],'string'],
            [['trans_date'],'safe'],
            [['journal_date'],'safe'],
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
        $query = Querybalance::find();

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
            //'trans_date' => $this->trans_date,
            'journal_date' => $this->journal_date,
            'engname' => $this->engname,
            'name' => $this->name,
            'volumn' => $this->volumn,
            'volumn_content' => $this->volumn_content,
            'unit_factor' => $this->unit_factor,

        ]);

//        if($this->globalSearch != ''){
            $query->orFilterWhere(['like','engname',$this->engname])
                ->orFilterWhere(['like','name',$this->name]);
//        }

        return $dataProvider;
    }
}
