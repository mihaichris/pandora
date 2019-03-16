<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Transaction;
use frontend\models\Wallet;
use common\components\Helper;
/**
 * TransactionSearch represents the model behind the search form of `frontend\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    public $sender_name;
    public $receiver_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sender_id', 'receiver_id', 'block_id'], 'integer'],
            [['amount'], 'number'],
            [['valid_at','sender_name','receiver_name', 'created_at', 'sender_address', 'receiver_address'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $myWallet = Wallet::findOne(['user_id'=>Yii::$app->user->identity->id]);
        $query = Transaction::find();
        $query->where(['sender_address'=>$myWallet->public_address]);
        $query->orWhere(['receiver_address'=>$myWallet->public_address]);
        $query->active();
        // add conditions that should always apply here
        $query->joinWith(['sender sender_profile','receiver receiver_profile']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['sender'] = [
            'asc' => ['sender_profile.name' => SORT_ASC],
            'desc' => ['sender_profile.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['receiver'] = [
            'asc' => ['receiver_profile.name' => SORT_ASC],
            'desc' => ['receiver_profile.name' => SORT_DESC],
        ];

        $this->load($params);
        // Helper::debug($dataProvider);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'amount' => $this->amount,
            'valid_at' => $this->valid_at,
            'block_id' => $this->block_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'sender_address', $this->sender_address])
            ->andFilterWhere(['like', 'sender_profile.name', $this->sender_name])
            ->andFilterWhere(['like', 'valid_at', $this->valid_at])
            ->andFilterWhere(['like', 'receiver_profile.name', $this->receiver_name]);
        // Helper::debug($dataProvider);
        return $dataProvider;
    }
}
