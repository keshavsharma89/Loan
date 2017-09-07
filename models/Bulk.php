<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for bulk upload
 *
 * @property integer $jfile
 * @property integer $myerror
 */
class Bulk extends Model
{
    /**
     * @var UploadedFile
     */
    public $jfile;
    public $myerror;

    public function rules()
    {
        return [
            [['jfile'], 'file', 'skipOnEmpty' => false],
        ];
    }
    
    /*
     * We will call this function from user controller to fetch the file content
     * then we will create the attributes and elemets array
     * and pass it to the function which will import the same to database
     * */
    public function users()
    {
        if($this->validate()){
            $filecontent=file_get_contents($this->jfile->tempName);
            $uarr=json_decode($filecontent);
            if($uarr=== null){
                return false;
            }else{
                $attr=['userId', 'firstName', 'lastName', 'email', 'personalCode', 'phone', 'active', 'isDead', 'lang'];
                $rows=[];
                foreach($uarr as $k=>$v){
                    $rows[$k][0]=$v->userId;
                    $rows[$k][1]=$v->firstName;
                    $rows[$k][2]=$v->lastName;
                    $rows[$k][3]=$v->email;
                    $rows[$k][4]=$v->personalCode;
                    $rows[$k][5]=$v->phone;
                    $rows[$k][6]=$v->active;
                    $rows[$k][7]=$v->isDead;
                    $rows[$k][8]=$v->lang;
                }
                $this->bulkinsert('users', $attr, $rows);
            }
            return true;
        }else{
            return false;
        }
    }
    
    /*
     * We will call this function from loan controller to fetch the file content
     * then we will create the attributes and elemets array
     * and pass it to the function which will import the same to database
     * */
    public function loans()
    {
        if($this->validate()){
            $filecontent=file_get_contents($this->jfile->tempName);
            $uarr=json_decode($filecontent);
            if($uarr=== null){
                return false;
            }else{
                $attr=["loanId", "userId", "amount", "interest", "duration", "dateApplied", "dateLoanEnds", "campaign", "status"];
                $rows=[];
                foreach($uarr as $k=>$v){
                    $rows[$k][0]=$v->loanId;
                    $rows[$k][1]=$v->userId;
                    $rows[$k][2]=$v->amount;
                    $rows[$k][3]=$v->interest;
                    $rows[$k][4]=$v->duration;
                    $rows[$k][5]=date('Y-m-d', $v->dateApplied);
                    $rows[$k][6]=date('Y-m-d', $v->dateLoanEnds);
                    $rows[$k][7]=$v->campaign;
                    $rows[$k][8]=$v->status;
                }
                $this->bulkinsert('loans', $attr, $rows);
            }
            return true;
        }else{
            return false;
        }
    }
    
    /*
     * This will accept table name, attributes, rows
     * @table is the name of the table where we need to upload all data
     * @attr will be the array of coloumn name
     * @rows is the array that contain the data in array form
     * */
    public function bulkinsert($table, $attr, $rows){
        try{
            Yii::$app->db->createCommand()->batchInsert($table, $attr, $rows)->execute();
        }catch(\Exception $e){
            $this->myerror=$e->errorInfo[2];
            return false;
        }
    }
}
