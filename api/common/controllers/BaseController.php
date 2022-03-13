<?php
namespace common\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\Cors;
use sizeg\jwt\JwtHttpBearerAuth;

class BaseController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		
		unset ($behaviors['authenticator']);
		
		$behaviors['corsFilter'] =  [
			'class' => Cors::className(),
			//'only' => ['index', 'login', 'logout'],
			'cors' => [
				// restrict access to
				'Origin' => ['*'],//, 'http://localhost:8080', 'http://127.0.0.1:8080'],
				'Access-Control-Request-Method' => ['POST', 'PUT', 'OPTIONS', 'GET'],
				'Access-Control-Request-Headers' => ['X-Wsse', 'X-PJAX-Container', 'X-PJAX', 'Authorization', 'Content-Type'],
			],
		];

		$behaviors['authenticator'] = [
				'class' => JwtHttpBearerAuth::class,
				'optional' => [/* optional actions*/ 'login', ],
				'except' => ['options']
		];
		
		return $behaviors;
		
	}
	
	public function beforeAction($action){
		Yii::$app->response->format = Response::FORMAT_JSON;
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
		$result = parent::afterAction($action, $result);
		
		if (Yii::$app->user->isGuest){
			return $result;
		}
		
		$user = Yii::$app->user->identity;
		$token = $user->getCurrentToken();
		
		if (!isset($result['token'])){
			$result['token'] = $token;
		}
		
		return $result;
	}
	
	protected function getPostData(){
		$raw_data = Yii::$app->request->getRawBody();
		$post = json_decode($raw_data, true);
		return $post;
	}
	
}