<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Loans;

/**
 * OrderSearch represents the model behind the search form about `app\models\Orders`.
 */
class LoanSearch extends Loans
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'duration', 'campaign', 'status'], 'integer'],
            [['amount', 'interest'], 'number'],
            [['dateApplied', 'dateLoanEnds', 'createdDate', 'username'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Loans::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);
        
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['LIKE', 'amount', $this->getAttribute('amount')])
              ->andFilterWhere(['LIKE', 'interest', $this->getAttribute('interest')])
              ->andFilterWhere(['LIKE', 'duration', $this->getAttribute('duration')])
              ->andFilterWhere(['=', 'dateApplied', $this->getAttribute('dateApplied')])
              ->andFilterWhere(['=', 'campaign', $this->getAttribute('campaign')])
              ->andFilterWhere(['=', 'status', $this->getAttribute('status')])
              ;
              
        return $dataProvider;
    }
}
