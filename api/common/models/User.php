<?php
namespace common\models;

use Yii;
use yii\web\IdentityInterface;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\Signer\Hmac\Sha256;

/**
 * User model
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $admin
 * @property integer $status
 * @property string $password_hash
 * @property string $auth_key
 * @property string $password_reset_token
 */
class User extends BaseModel implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        	[['email'], 'string'],
        	[['email'], 'required'],
        	[['email'], 'unique'],
			[['admin',], 'integer'],
        	['auth_key', 'default', 'value' => ''],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @param Token $token
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    	/*
    	 * The uid of the token is the user id
    	 */
    	return static::findOne(['id' =>  (string) $token->getClaim('uid'), 'status' => self::STATUS_ACTIVE]);
    	
    	return null;
    }
    
    public function getCurrentToken(){
    	$signer = new Sha256();
    	$user = $this;
    	$userData = [
				'id' => $user->id,
    			'email' => $user->email,
				'name' => $user->name,
    			'admin' => $user->admin,
    			'about' => 'Main user',
    			'img' => 'avatar-s-11.png',
    			'status' => 'online',
    	];
    	
    	/** @var Jwt $jwt */
    	$jwt = Yii::$app->jwt;
    	$token = $jwt->getBuilder()
	    	->setIssuer(Yii::$app->params['backendUrl'])// Configures the issuer (iss claim)
	    	->setAudience(Yii::$app->params['frontendUrl'])// Configures the audience (aud claim)
	    	->setId('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
	    	->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
	    	->setExpiration(time() + 3600)// Configures the expiration time of the token (exp claim)
	    	->set('uid', Yii::$app->user->identity->id)// Configures a new claim, called "uid"
	    	->set('data', $userData)
	    	->sign($signer, $jwt->key)// creates a signature using [[Jwt::$key]]
	    	->getToken(); // Retrieves the generated token
	    return (string)$token;
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => strtolower(trim($email)), 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
