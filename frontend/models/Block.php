<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "block".
 *
 * @property int $id
 * @property string $timestamp
 * @property string $previous_hash
 * @property int $miner_id
 * @property double $fees
 * @property string $proof_of_work
 *
 * @property Miner $miner
 * @property Hash $hash
 * @property Transaction[] $transactions
 */
class Block extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timestamp'], 'safe'],
            [['miner_id', 'proof_of_work'], 'integer'],
            [['fees'], 'number'],
            [['previous_hash'], 'string', 'max' => 200],
            [['miner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Miner::class, 'targetAttribute' => ['miner_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'timestamp' => 'Timestamp',
            'previous_hash' => 'Previous Hash',
            'miner_id' => 'Miner ID',
            'fees' => 'Fees',
            'proof_of_work' => 'Proof Of Work',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMiner()
    {
        return $this->hasOne(Miner::class, ['user_id' => 'miner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHash()
    {
        return $this->hasOne(Hash::class, ['block_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, ['block_id' => 'id']);
    }

    public static function getBlock($id)
    {
        return     (new Query())
            ->select(['block.id as block_index',
                'miner_user.username as miner_username',
                'sender_user.username as sender_username',
                'receiver_user.username as receiver_username',
                'miner.name as miner_name',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'block.fees',
                'block.proof_of_work',
                'block.timestamp',
                'transaction.amount as transaction_amount',
                'transaction.created_at as transaction_created_at',
                'hash.hash as block_hash',
                'block.previous_hash as previous_block_hash'])
            ->from('transaction')
            ->innerJoin('block', 'block.id = transaction.block_id')
            ->innerJoin('user miner_user', 'miner_user.id=block.miner_id')
            ->innerJoin('user receiver_user', 'receiver_user.id=transaction.receiver_id')
            ->innerJoin('user sender_user', 'sender_user.id=transaction.sender_id')
            ->innerJoin('profile miner', 'miner.user_id=miner_user.id')
            ->innerJoin('profile receiver', 'receiver.user_id=receiver_user.id')
            ->innerJoin('profile sender', 'sender.user_id=sender_user.id')
            ->innerJoin('hash', 'hash.block_id=block.id')
            ->where(['block.id' => $id])
            ->all();
    }
}
