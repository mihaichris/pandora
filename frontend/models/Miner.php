<?php

namespace frontend\models;

use common\models\User;
use frontend\models\query\MinerQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "miner".
 *
 * @property int $id
 * @property int $user_id
 * @property string $created_at
 *
 * @property Block[] $blocks
 * @property User $user
 */
class Miner extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'miner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
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
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(Block::class, ['miner_id' => 'id']);
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
     * @return \frontend\models\query\MinerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MinerQuery(get_called_class());
    }
}
