<?php

namespace app\models;

use Yii;

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
 * @property Loans[] $loans
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'email', 'personalCode', 'phone', 'active', 'isDead', 'lang'], 'required'],
            [['personalCode', 'phone', 'active', 'isDead'], 'integer'],
            [['createdDate', 'dead', 'isactive'], 'safe'],
            [['firstName', 'lastName', 'email'], 'string', 'max' => 225],
            [['lang'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email',
            'personalCode' => 'Personal Code',
            'phone' => 'Phone',
            'active' => 'Active',
            'isDead' => 'Is Dead',
            'lang' => 'Lang',
            'createdDate' => 'Created Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoans()
    {
        return $this->hasMany(Loans::className(), ['userId' => 'userId']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTotalLoans()
    {
        return sizeof($this->loans);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAge()
    {
        $number= $this->personalCode;
		$array=array_map('intval', str_split($number));
        $dob=$array[1].$array[2].'-'.$array[3].$array[4].'-'.$array[5].$array[6];
        return (date('Y') - date('Y',strtotime($dob)));
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDead()
    {
        if($this->isDead){
			return 'Dead';
		}else{
			return 'Alive';
		}
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsactive()
    {
        if($this->active){
			return 'Active';
		}else{
			return 'Inactive';
		}
    }
}
