<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Loans;
use app\models\Users;
use app\models\LoanForm;
use app\models\LoanSearch;
use app\models\Bulk;

class LoanController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    /*
     * This function will return the array for all available user 
     * */
    public function userDropdown()
    {
        // we will fetch all the user firstname and last name combine then and use Id as the key to our dropdown
        $userlist= Users::find()->select(['userId', 'firstName', 'lastName'])->asArray()->all();
        $users=[];
        foreach($userlist as $user){
            $users[$user['userId']]=$user['firstName']." ".$user['lastName'];
        }
        return $users;
    }

    /**
     * Displays page for add new loan.
     * AddloanForm is custom model create specialy to add new loans to the database
     * @return string
     */
    public function actionAdd()
    {
        $model =new LoanForm();
        $users=$this->userDropdown();
        $message= '';
        /*
         * On submit we will save loan to database using add function and show success message when done.
         * add is defined in model AddloanForm
         * */
        if($model->load(Yii::$app->request->post()) && $model->add() ){
			$message= "loan added successfully";
			$model =new LoanForm();
        }
        
        return $this->render('add', [
            'model' => $model,
            'title' => 'Add Loan',
            'message' =>$message,
            'users'=>$users,
        ]);
    }
    
    
    /**
     * Displays page for add new loan.
     * AddloanForm is custom model create specialy to add new loans to the database
     * @return string
     */
    public function actionUpdate($id)
    {
        $model= new LoanForm;
        $model->findloan($id);
        $users=$this->userDropdown();
        $message= '';
        // on submit we will save loan to database using add function and show success message when done.
        if($model->load(Yii::$app->request->post()) && $model->add($id)){ 
            $message= "loan updated successfully";
        }
        
        return $this->render('add', [
            'model' => $model,
            'title' => 'Update Loan',
            'message' =>$message,
            'users'=>$users,
        ]);
    }
    
    /*
     * This function is used to delete the user.
     * */
    public function actionDelete($id)
    {
        $model=Loans::findone($id);
        $model->delete();
        /*
         * Once the deletion is done we will redirect back to the main list
         * from where we got the trigure to delete in the first place.
         * */
        return $this->redirect(['list']);
    }
    
    /*
     * This fucntion is used to show the complete listing of the loans
     * */
    public function actionList()
    {
        $loansearch= new LoanSearch();
        $dataProvider = $loansearch->search(Yii::$app->request->get());
        
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'searchmodel' => $loansearch
        ]);
    }
    

    /**
     * Displays page for add new loan.
     * AddloanForm is custom model create specialy to add new loans to the database
     * @return string
     */
    public function actionBulkadd()
    {
        $model =new Bulk();
        $message= '';
        $errmsg= '';
        /*
         * On submit we will save loan to database using add function and show success message when done.
         * */
        if(Yii::$app->request->isPost){
			$model->jfile = UploadedFile::getInstance($model, 'jfile');
			if($model->loans()){
				if($model->myerror===null || $model->myerror==''){
					$message= "User saved successfully";
				}else{
					$errmsg= $model->myerror;
				}
			}
		}
        
        return $this->render('bulkadd', [
            'model' => $model,
            'title' => 'Add Multiple Loans',
            'message' =>$message,
            'errmsg' =>$errmsg,
        ]);
    }
}
