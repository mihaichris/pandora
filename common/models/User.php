<?php

namespace common\models;

use Yii;
use dektrium\user\models\User as BaseUser;
/**
* This is the model class for table "user".
*
* @property int $id
* @property string $username
* @property string $email
* @property string $password_hash
* @property string $auth_key
* @property int $confirmed_at
* @property string $unconfirmed_email
* @property int $blocked_at
* @property string $registration_ip
* @property int $created_at
* @property int $updated_at
* @property int $flags
* @property int $last_login_at
* @property int $status
* @property int $password_reset_token
* @property string $subscribed
*
* @property Article[] $articles
* @property Article[] $articles0
* @property Profile $profile
* @property SocialAccount[] $socialAccounts
* @property Token[] $tokens
*/
class User extends BaseUser
{

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'username'          => \Yii::t('user', 'Username'),
            'email'             => \Yii::t('user', 'Email'),
            'registration_ip'   => \Yii::t('user', 'Registration ip'),
            'unconfirmed_email' => \Yii::t('user', 'New email'),
            'password'          => \Yii::t('user', 'Password'),
            'created_at'        => \Yii::t('user', 'Registration time'),
            'last_login_at'     => \Yii::t('user', 'Last login'),
            'confirmed_at'      => \Yii::t('user', 'Confirmation time'),
            'subscribed'        => Yii::t('user', 'Subscription time'),
        ];
    }
}
