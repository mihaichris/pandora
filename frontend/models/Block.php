<?php

namespace frontend\models;

use yii\db\ActiveRecord;

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
}
