<?php

namespace frontend\models;

use Yii;
use common\models\User; 

/**
 * This is the model class for table "wallet".
 *
 * @property int $id
 * @property int $user_id
 * @property string $private_address
 * @property string $public_address
 * @property double $balance
 * @property string $created_at
 *
 * @property User $user
 */
class Wallet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wallet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'private_address', 'public_address'], 'required'],
            [['user_id'], 'integer'],
            [['balance'], 'number'],
            [['created_at'], 'safe'],
            [['private_address', 'public_address'], 'string', 'max' => 3000],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'private_address' => 'Private Address',
            'public_address' => 'Public Address',
            'balance' => 'Balance',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\query\WalletQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\query\WalletQuery(get_called_class());
    }
}
