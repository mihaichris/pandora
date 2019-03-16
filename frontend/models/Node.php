<?php

namespace frontend\models;


use common\models\User;
use Yii;

/**
 * This is the model class for table "node".
 *
 * @property int $id
 * @property int $user_id
 * @property string $node_address
 *
 * @property User $user
 */
class Node extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'node';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['node_address'], 'string', 'max' => 100],
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
            'node_address' => 'Node Address',
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
     * @return \frontend\models\query\NodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\query\NodeQuery(get_called_class());
    }
}
