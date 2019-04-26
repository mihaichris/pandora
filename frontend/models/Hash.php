<?php

namespace frontend\models;

use frontend\models\query\HashQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "hash".
 *
 * @property int $id
 * @property int $block_id
 * @property string $hash
 *
 * @property Block $block
 */
class Hash extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hash';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['block_id'], 'integer'],
            [['hash'], 'string', 'max' => 200],
            [['block_id'], 'unique'],
            [['block_id'], 'exist', 'skipOnError' => true, 'targetClass' => Block::class, 'targetAttribute' => ['block_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'block_id' => 'Block ID',
            'hash' => 'Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(Block::class, ['id' => 'block_id']);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\query\HashQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HashQuery(get_called_class());
    }
}
