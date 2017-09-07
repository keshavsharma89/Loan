<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "users".
 *
 * @property integer $userId
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property integer $personalCode
 * @property integer $phone
 * @property integer $active
 * @property integer $isDead
 * @property string $lang
 * @property string $createdDate
 *
 * @property Loans $loans
 */
class UserForm extends Model
{
	public $firstName;
    public $lastName;
    public $email;
    public $personalCode;
    public $phone;
    public $active;
    public $isDead;
    public $lang;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'email', 'personalCode', 'phone', 'active', 'isDead', 'lang'], 'required'],
            ['email', 'email'],
            [['personalCode', 'phone', 'active', 'isDead'], 'integer'],
            [['personalCode'], 'string', 'min' => 11],
            [['createdDate'], 'safe'],
            [['firstName', 'lastName', 'email'], 'string', 'max' => 225],
            [['lang'], 'string', 'max' => 100],
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
				$user= new Users;
			}else{
				// selecting the correct orderid which we need to update
				$user= Users::find()->where(['userId'=>$id])->one();
			}
            $user->firstName=$this->firstName;
			$user->lastName=$this->lastName;
			$user->email=$this->email;
			$user->personalCode=$this->personalCode;
			$user->phone=$this->phone;
			$user->active=$this->active;
			$user->isDead=$this->isDead;
			$user->lang=$this->lang;
            return $user->save();
        }
        return false;
    }
    
    /*
     * We will use this function to find the current values in the table while we try to update any user
     * */
    public function finduser($id)
    {
        $user=Users::find()->where(['userId'=>$id])->one();
        $this->firstName=$user->firstName;
		$this->lastName=$user->lastName;
		$this->email=$user->email;
		$this->personalCode=$user->personalCode;
		$this->phone=$user->phone;
		$this->active=$user->active;
		$this->isDead=$user->isDead;
		$this->lang=$user->lang;
        return true;
    }
}
