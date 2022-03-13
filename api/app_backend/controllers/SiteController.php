<?php
namespace app_backend\controllers;

use Yii;
use common\controllers\BaseController;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
    	$behaviors = parent::behaviors();
    	
    	$auth = $behaviors['authenticator'];
    	$behaviors['authenticator']['optional'] = ['login'];
    	
    	return $behaviors;
    	
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
    	
    	$raw_data = Yii::$app->request->getRawBody();
    	$post = json_decode($raw_data, true);
    	
        $model = new LoginForm();
        $postLoaded = $model->load($post);

        $logedIn = $model->login();
        
        if ($postLoaded && $logedIn) {

	        /** @var \User $user */
	        $user = Yii::$app->user->identity;

	        $token = $user->getCurrentToken();
	        return [
	        		'token' => (string)$token,
	        ];
        }
        else {
        	return [
        			'token' => false,
        			'logedIn' => $logedIn,
        			'error' => 'Incorrect Email or Password',
        			'postLoaded' => $postLoaded,
        			'post'=> $post
        	];
        }
    }
	
    
    public function actionMe(){
    	if (Yii::$app->user->isGuest){
    		return ['token' => false, 'login' => false];
    	}
    	$user = Yii::$app->user->identity;
    	
    	return ['login' => true];
    }
    
    

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
