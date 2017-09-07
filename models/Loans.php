<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loans".
 *
 * @property integer $loanId
 * @property integer $userId
 * @property double $amount
 * @property double $interest
 * @property integer $duration
 * @property string $dateApplied
 * @property string $dateLoanEnds
 * @property integer $campaign
 * @property integer $status
 * @property string $createdDate
 *
 * @property Users $user
 */
class Loans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'amount', 'interest', 'duration', 'dateApplied', 'dateLoanEnds', 'campaign', 'status'], 'required'],
            [['userId', 'duration', 'campaign', 'status'], 'integer'],
            [['amount', 'interest'], 'number'],
            [['dateApplied', 'dateLoanEnds', 'createdDate'], 'safe'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['userId' => 'userId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loanId' => 'Loan ID',
            'userId' => 'User ID',
            'amount' => 'Amount',
            'interest' => 'Interest',
            'duration' => 'Duration',
            'dateApplied' => 'Date Applied',
            'dateLoanEnds' => 'Date Loan Ends',
            'campaign' => 'Campaign',
            'status' => 'Status',
            'createdDate' => 'Created Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['userId' => 'userId']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsername()
    {
        return $this->user['firstName']." ".$this->user['lastName'];
    }
}
