<?php

namespace app\modules\admin\models;

use app\modules\admin\models\Users;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;



    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
         $userd=Users::find()->where("id='{$id}'")->one();
         return !empty($userd) ? new User($userd) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          $userd=Users::find()->where("accessToken='{$token}'")->one();
         return !empty($userd) ? new User($userd) : null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $userd=Users::find()->where("username='{$username}'")->one();
        return  new User($userd);

    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
}
