<?php

namespace app_backend\controllers;

use Yii;
use Exception;
use common\controllers\BaseController;
use common\models\User;

class UsersController extends BaseController {
	
	public function actionIndex()
	{
		$users = [];
		
		if(Yii::$app->user->identity->admin) {
			$users = User::find()->all();
		}
		
		return [
			'users' => $users
		];
	}
	
	public function actionUserData($id){
		$user = User::findOne(['id' => $id]);
		if (!$user){
			return ['error' => 'User not Found'];
		}
		
		return [
			'user' => $user,
		];
	}
	
	public function actionCreate()
	{
		$manager = Yii::$app->user->identity; 
		if (Yii::$app->request->isPost)
		{
			$post = $this->getPostData();
			try {
				$transaction = Yii::$app->db->beginTransaction();
					$user = new User();
					$user->load($post);
					
					$user->password = '';
					if ($post['User']['password'] != ''){
						$user->password = $post['User']['password'];
					}
					else {
						$user->addError('password', 'Password cannot be blank');
						return [
							'userErrors' => $user->errors
						];
					}
					$user->status = $post['User']['status'];
					$user->manager_id = $manager->id;
					
					
					$saved = $user->save();
					if (!$saved){
						$transaction->rollBack();
						return [	
							'userErrors' => $user->errors
						];
					}
					
				$transaction->commit();
			}
			catch (Exception $e){
				$transaction->rollBack();
				return ['error' => $e->getMessage()];
			}
			return [
				'success' => true,
				'user' => $user,
			];
		}
		return ['error' => 'There was an error'];
	}
	
	public function actionUpdate($id)
	{
		$manager = Yii::$app->user->identity;
		if (Yii::$app->request->isPost)
		{
			$post = $this->getPostData();
			try {
				$transaction = Yii::$app->db->beginTransaction();
				$user = User::findOne(['id' => $id, 'manager_id' => $manager->id]);
				if (!$user){
					return [
						'error' => 'User not found'
					];
				}
				$user->load($post);
				
				if ($post['User']['password'] != ''){
					$user->password = $post['User']['password'];
				}
				
				$user->status = $post['User']['status'];
				
				$saved = $user->save();
				if (!$saved){
					$transaction->rollBack();
					return [
							'userErrors' => $user->errors
					];
				}
				
				$transaction->commit();
			}
			catch (Exception $e){
				$transaction->rollBack();
				return ['error' => $e->getMessage()];
			}
			return [
					'success' => true,
					'user' => $user,
			];
		}
		return ['error' => 'There was an error'];
	}
	
}