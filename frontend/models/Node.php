<?php

namespace frontend\models;


use common\models\User;
use frontend\models\query\NodeQuery;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "node".
 *
 * @property int $id
 * @property int $user_id
 * @property string $node_address
 *
 * @property User $user
 */
class Node extends ActiveRecord
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
        return new NodeQuery(get_called_class());
    }


    public static function getUserNode($id){
        return (new Query())->select(['user.username', 'profile.public_email as email', 'profile.bio', 'profile.name', 'profile.location', 'node.node_address', 'auth_assignment.item_name as role', 'FROM_UNIXTIME(user.created_at) as created_at'])
            ->from('node')
            ->innerJoin('user', 'user.id=node.user_id')
            ->innerJoin('profile', 'profile.user_id=user.id')
            ->innerJoin('auth_assignment', 'auth_assignment.user_id=user.id')
            ->where(['node.user_id' => $id])
            ->one();
    }
}
