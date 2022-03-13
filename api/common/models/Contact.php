<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property int $subscribed
 * @property int $deleted
 */
 
class Contact extends BaseModel
{
	
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%contact}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['name', 'email'], 'required'],
            [['subscribed', 'deleted'], 'integer'],
            [['name', 'email', 'address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 10],
            [['email'], 'unique'],
			['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'subscribed' => 'Subscribed',
            'deleted' => 'Deleted',
        ];
    }
	
}
