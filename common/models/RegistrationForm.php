<?php

namespace common\models;

use Yii;

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
 class RegistrationForm extends \dektrium\user\models\RegistrationForm
 {
     /**
      * @var string
      */
     public $captcha;
     /**
      * @inheritdoc
      */
     public function rules()
     {
         $rules = parent::rules();
         $rules[] = ['captcha', 'required'];
         $rules[] = ['captcha', 'captcha'];
         return $rules;
     }
 }
