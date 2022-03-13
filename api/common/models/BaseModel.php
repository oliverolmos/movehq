<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function getDb(){
		return Yii::$app->get('db');
	}
}