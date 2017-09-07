<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for loans add form
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
class LoanForm extends Model
{
    public $loanId;
    public $userId;
    public $amount;
    public $interest;
    public $duration;
    public $dateApplied;
    public $dateLoanEnds;
    public $campaign;
    public $status;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
		return [
            [['userId', 'amount', 'interest', 'duration', 'dateApplied', 'dateLoanEnds', 'campaign', 'status'], 'required'],
            [['loanId', 'userId', 'duration', 'campaign', 'status'], 'integer'],
            [['amount', 'interest'], 'number'],
            [['dateApplied', 'dateLoanEnds', 'createdDate'], 'safe'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['userId' => 'userId']],
        ];
    }

    /**
     * This function will insert new order to the order table 
     * and at the same time we can edit them too.
     * $id will contain the Order Id if we need to edit any
     * incase of no id we will create a new record in the table
     */
    public function add($id=0)
    {
        if ($this->validate()){
	       if($id==0){
				//$id is zero, that means we will need to create a new entry in the database
				$loan= new Loans;
			}else{
				// selecting the correct orderid which we need to update
				$loan= Loans::find()->where(['loanId'=>$id])->one();
			}
			
			$loan->userId=$this->userId;
			$loan->amount=$this->amount;
			$loan->interest=$this->interest;
			$loan->duration=$this->duration;
			$loan->dateApplied=$this->dateApplied;
			$loan->dateLoanEnds=$this->dateLoanEnds;
			$loan->campaign=$this->campaign;
			$loan->status=$this->status;
			return $loan->save();
        }
        return false;
    }
    
    /*
     * We will use this function to find the current values in the table while we try to update any user
     * */
    public function findloan($id)
    {
        $loan=Loans::find()->where(['loanId'=>$id])->one();
        $this->userId=$loan->userId;
		$this->amount=$loan->amount;
		$this->interest=$loan->interest;
		$this->duration=$loan->duration;
		$this->dateApplied=$loan->dateApplied;
		$this->dateLoanEnds=$loan->dateLoanEnds;
		$this->campaign=$loan->campaign;
		$this->status=$loan->status;
        return true;
    }
}
