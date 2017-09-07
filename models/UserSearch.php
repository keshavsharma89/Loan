<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * OrderSearch represents the model behind the search form about `app\models\Orders`.
 */
class UserSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'email'], 'string', 'max' => 225],
            [['personalCode', 'phone', 'active', 'isDead'], 'integer'],
            [['createdDate', 'totalLoans', 'age'], 'safe'],
            [['lang'], 'string', 'max' => 100],
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
    
    public function attributes()
    {
        return array_merge(parent::attributes(), ['totalLoans']);
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Users::find();
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
        $query->andFilterWhere(['LIKE', 'firstName', $this->getAttribute('firstName')])
              ->andFilterWhere(['LIKE', 'lastName', $this->getAttribute('lastName')])
              ->andFilterWhere(['LIKE', 'email', $this->getAttribute('email')])
              ->andFilterWhere(['LIKE', 'personalCode', $this->getAttribute('personalCode')])
              ->andFilterWhere(['LIKE', 'phone', $this->getAttribute('phone')]);

        return $dataProvider;
    }
}
