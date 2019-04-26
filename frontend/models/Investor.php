<?php

namespace frontend\models;

use common\models\User;
use frontend\models\query\InvestorQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "investor".
 *
 * @property int $id
 * @property int $user_id
 * @property string $created_at
 *
 * @property User $user
 */
class Investor extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'investor';
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
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\query\InvestorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvestorQuery(get_called_class());
    }
}
