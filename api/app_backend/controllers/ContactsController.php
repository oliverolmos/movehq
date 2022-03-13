<?php
namespace app_backend\controllers;

use Yii;
use common\controllers\BaseController;
use common\models\Contact;

class ContactsController extends BaseController 
{
	
	public function actionIndex()
	{
		$contacts = Contact::find()->all();
		return ['contacts' => $contacts];
	}
}