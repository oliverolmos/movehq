<?php
	
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Contact;
use common\models\User;

class TestDataController extends Controller
{
	public $defaultAction = 'run';
	
	public function actionRun()
	{
		echo "Creating test user.....\n";

		$user = new User();
		$user->name = 'Oliver Olmos';
		$user->email = 'olmosoliver@gmail.com';
		$user->admin = 1;
		$user->status = 1;
		$user->auth_key = 'Up378mQ95jCrvJkl95GJUDLVX8Hdj8TP';
		$user->password_hash = Yii::$app->security->generatePasswordHash('12345678');
		$user->save();
		
		echo "Creating test contacts.....\n";
		
		$contact1 = new Contact();
		$contact1->name = 'John Smith';
		$contact1->email = 'john_smith@gmail.com';
		$contact1->phone = '6191234567';
		$contact1->address = '123 Main St, San Diego, CA 92110';
		$contact1->subscribed = 1;
		$contact1->save();
		
		$contact2 = new Contact();
		$contact2->name = 'Mary Jefferson';
		$contact2->email = 'mary_jefferson@gmail.com';
		$contact2->phone = '6192223333';
		$contact2->address = '2525 1st St, San Diego, CA 92111';
		$contact2->subscribed = 0;
		$contact2->save();
		
		echo "Done!\n";
	}
	
	
}