<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Users;
use app\models\UserForm;
use app\models\UserSearch;
use app\models\Bulk;

class UserController extends Controller
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

    /**
     * Displays page for add new user.
     * AddUserForm is custom model create specialy to add new users to the database
     * @return string
     */
    public function actionAdd()
    {
        $model =new UserForm();
        $message= '';
        /*
         * On submit we will save user to database using add function and show success message when done.
         * add is defined in model AdduserForm
         * */
        if($model->load(Yii::$app->request->post()) && $model->add()){
            $message= "User saved successfully";
            $model =new UserForm();
        }
        
        return $this->render('adduser', [
            'model' => $model,
            'title' => 'Add User',
            'message' =>$message,
        ]);
    }
    
    
    /**
     * Displays page for add new user.
     * AdduserForm is custom model create specialy to add new users to the database
     * @return string
     */
    public function actionUpdate($id)
    {
        $model= new UserForm;
        $model->finduser($id);
        
        $message= '';
        // on submit we will save user to database using add function and show success message when done.
        if($model->load(Yii::$app->request->post()) && $model->add($id)){ 
            $message= "User edited successfully";
        }
        
        return $this->render('adduser', [
            'model' => $model,
            'title' => 'Update User',
            'message' =>$message,
        ]);
    }
    
    /*
     * This function is used to delete the user.
     * */
    public function actionDelete($id)
    {
        $model=Users::findone($id);
        $model->delete();
        /*
         * Once the deletion is done we will redirect back to the main list
         * from where we got the trigure to delete in the first place.
         * */
        return $this->redirect(['list']);
    }
    
    /*
     * This fucntion is used to show the complete listing of the users
     * */
    public function actionList()
    {
        $usersearch= new UserSearch();
        $dataProvider = $usersearch->search(Yii::$app->request->get());
        
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'searchmodel' => $usersearch
        ]);
    }
    

    /**
     * Displays page for add new user.
     * AdduserForm is custom model create specialy to add new users to the database
     * @return string
     */
    public function actionBulkadd()
    {
        $model =new Bulk();
        $message= '';
        $errmsg= '';
        /*
         * On submit we will save user to database using add function and show success message when done.
         * */
        if(Yii::$app->request->isPost){
            $model->jfile = UploadedFile::getInstance($model, 'jfile');
            if($model->users()){
                if($model->myerror===null || $model->myerror==''){
                    $message= "User saved successfully";
                }else{
                    $errmsg= $model->myerror;
                }
            }
        }
        
        return $this->render('bulkadd', [
            'model' => $model,
            'title' => 'Add Multiple Users',
            'message' =>$message,
            'errmsg' =>$errmsg,
        ]);
    }
}
