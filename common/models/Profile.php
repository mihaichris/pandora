<?php

namespace common\models;

use Yii;
use dektrium\user\models\Profile as BaseProfile;
use dektrium\user\traits\ModuleTrait;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property string $name
 * @property string $last_name
 * @property string $public_email
 * @property integer $age
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $bio
 * @property string $timezone
 *
 * @property User $user
 */
class Profile extends BaseProfile
{
    public function attributeLabels()
    {
        return [
            'last_name'           => \Yii::t('user', 'Last name'),
            'age'                 => \Yii::t('user', 'Age'),
        ];
    }

    public function scenarios()
   {
       $scenarios = parent::scenarios();
       // add field to scenarios
       $scenarios['create'][]   = ['last_name','age'];
       $scenarios['update'][]   = ['last_name','age'];
       $scenarios['register'][] = ['last_name','age'];
       return $scenarios;
   }

   public function rules()
   {
       $rules = parent::rules();
       // add some rules
       $rules['lastnameRequired'] = ['last_name', 'required'];
      $rules['ageRequired'] = ['age', 'required'];
       //$rules['lastnameLength']   = ['last_name', 'string', 'max' => 255];
       //$rules['ageLength'] = ['age', 'integerOnly'=>true];

       return $rules;
   }
}
