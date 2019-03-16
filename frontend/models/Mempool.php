<?php

namespace frontend\models;

use Yii;
use common\models\User;
use common\models\Profile;

/**
 * This is the model class for table "mempool".
 *
 * @property int $id
 * @property string $sender_address
 * @property string $receiver_address
 * @property double $amount
 * @property int $user_id
 * @property string $created_at 
 *
 * @property User $user
 */
class Mempool extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mempool';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'], 
            [['sender_address', 'receiver_address'], 'string', 'max' => 500],
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
            'sender_address' => 'Sender Address',
            'receiver_address' => 'Receiver Address',
            'amount' => 'Amount',
            'user_id' => 'User ID',
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
     * @return \frontend\models\query\MempoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\query\MempoolQuery(get_called_class());
    }
}
