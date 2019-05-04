<?php

namespace frontend\models;

use frontend\models\query\TransactionQuery;
use kartik\grid\GridView;
use Yii;
use common\models\User;
use common\models\Profile;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property double $amount
 * @property string $valid_at
 * @property int $block_id
 * @property string $created_at
 * @property string $sender_address
 * @property string $receiver_address
 * @property string $status
 *
 * @property Block $block
 * @property User $sender
 * @property User $receiver
 */
class Transaction extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_id', 'receiver_id'], 'required'],
            [['sender_id', 'receiver_id', 'block_id'], 'integer'],
            [['amount'], 'number'],
            [['valid_at', 'created_at'], 'safe'],
            [['status'], 'string'],
            [['sender_address', 'receiver_address'], 'string', 'max' => 500],
            [['block_id'], 'exist', 'skipOnError' => true, 'targetClass' => Block::class, 'targetAttribute' => ['block_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['sender_id' => 'id']],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['receiver_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'amount' => 'Amount',
            'valid_at' => 'Valid At',
            'block_id' => 'Block ID',
            'created_at' => 'Created At',
            'sender_address' => 'Sender Address',
            'receiver_address' => 'Receiver Address',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(Block::class, ['id' => 'block_id']);
    }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getSender()
    // {
    //     return $this->hasOne(User::className(), ['id' => 'sender_id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getReceiver()
    // {
    //     return $this->hasOne(User::className(), ['id' => 'receiver_id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'receiver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'sender_id']);
    }


    /**
     * {@inheritdoc}
     * @return \frontend\models\query\TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionQuery(get_called_class());
    }
}
