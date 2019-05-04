<?php

namespace frontend\models\search;

use common\models\Profile;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Transaction;
use frontend\models\Wallet;
use common\components\Helper;
use yii\db\Query;
use yii\helpers\ArrayHelper;

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
            [['valid_at', 'sender_name', 'receiver_name', 'created_at', 'sender_address', 'receiver_address'], 'safe'],
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
        $myWallet = Wallet::findOne(['user_id' => Yii::$app->user->identity->id]);
        $query = Transaction::find();
        $query->where(['sender_address' => $myWallet->public_address]);
        $query->orWhere(['receiver_address' => $myWallet->public_address]);
        $query->active();
        // add conditions that should always apply here
        $query->joinWith(['sender sender_profile', 'receiver receiver_profile']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['sender_profile'] = [
            'asc' => ['sender_profile.name' => SORT_ASC],
            'desc' => ['sender_profile.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['receiver_profile'] = [
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

    /**
     * @return array
     */
    public function getHtmlGridColumns()
    {
        return [
            // [
            //     'label'=>'Expeditor',
            //     'attribute'=>'sender_name',
            //     'value'=>'sender.name'
            // ],
            [
                'label' => 'Expeditor',
                'attribute' => 'sender_name',
                // 'vAlign' => 'middle',
                // 'width' => '180px',
                'value' => 'sender.name',
                // 'value' => function ($model, $key, $index, $widget) {
                //     return Html::a($model->author->name,
                //         '#',
                //         ['title' => 'View author detail', 'onclick' => 'alert("This will open the author page.\n\nDisabled for this demo!")']);
                // },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Profile::find()->where("name!='Admin'")->orderBy('name')->asArray()->all(), 'name', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Alege un beneficiar..'],
                'format' => 'raw'
            ],
            [
                'label' => 'Beneficiar',
                'attribute' => 'receiver_name',
                // 'vAlign' => 'middle',
                // 'width' => '180px',
                'value' => 'receiver.name',
                // 'value' => function ($model, $key, $index, $widget) {
                //     return Html::a($model->author->name,
                //         '#',
                //         ['title' => 'View author detail', 'onclick' => 'alert("This will open the author page.\n\nDisabled for this demo!")']);
                // },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Profile::find()->where("name!='Admin'")->orderBy('name')->asArray()->all(), 'name', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Alege un beneficiar..'],
                'format' => 'raw'
            ],
            // [
            //     'label'=>'Beneficiar',
            //     'attribute'=>'receiver_name',
            //     'value'=> 'receiver.name'
            // ],
            [
                'label' => 'Valoarea tranzacției',
                'attribute' => 'amount',
                'value' => 'amount'
            ],
            [
                'label' => 'Validată la data',
                'attribute' => 'valid_at',
                'value' => 'valid_at'
            ],
            // ['class'        => 'kartik\grid\ActionColumn',
            //     'header'        => 'Actions',
            //     'headerOptions' => ['style' => 'color:#337ab7'],
            //     'template'      => '{view}',
            //     'buttons'       => [
            //         'view'   => function ($url, $model)
            //         {
            //             return Html::a('<i class="material-icons">person</i>', $url, [
            //                 //'data-toggle'=>"tooltip",'data-placement'=>'top','title'=>'Vezi profil.'
            //             ]);
            //         },
            //     ],
            // ],
        ];
    }

    /**
     * @return string
     */
    public function getGridLayout()
    {
        return <<< HTML
        <div class="card card-stats">
                <div class="card-header" data-background-color="blue">
                    <i class="material-icons">list_alt</i>
                </div>
                <h4 class="card-title">Istoricul tranzacțiilor</h4>
        <div class="float-right">
            {summary}
        </div>
        <div class="clearfix"></div>
        <div class="card-body">
        {items}
        {pager}
        </div>
        </div>
HTML;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getGridExportMenu()
    {
        return ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'target' => ExportMenu::TARGET_BLANK,
            'pjaxContainerId' => 'kv-pjax-container',
            'exportContainer' => [
                'class' => 'btn-group mr-2',
            ],
            'dropdownOptions' => [
                'label' => 'Full',
                'class' => 'btn btn-secondary',
                'itemsBefore' => [
                    '<div class="dropdown-header">Export All Data</div>',
                ],
            ],
        ]);
    }

    public function getMempoolTransactions($getMyAddress)
    {
        return (new Query())
            ->select(['mempool.id', 'sender.name sender', 'receiver.name receiver', 'mempool.amount amount', 'mempool.created_at created_at'])
            ->from('mempool')
            ->innerJoin('wallet sender_wallet', 'sender_wallet.public_address = mempool.sender_address')
            ->innerJoin('wallet receiver_wallet', 'receiver_wallet.public_address = mempool.receiver_address')
            ->innerJoin('user sender_user', 'sender_wallet.user_id = sender_user.id')
            ->innerJoin('user receiver_user', 'receiver_wallet.user_id = receiver_user.id')
            ->innerJoin('profile sender', 'sender.user_id = sender_user.id')
            ->innerJoin('profile receiver', 'receiver.user_id = receiver_user.id')
            ->where(['mempool.sender_address' => $getMyAddress->public_address])
            ->orWhere(['mempool.receiver_address' => $getMyAddress->public_address])
            ->all();
    }

    public function getMempoolTransaction($getMyAddress, $id)
    {
        return (new Query())
            ->select(['mempool.id', 'sender.name sender', 'receiver.name receiver', 'mempool.amount amount', 'mempool.created_at created_at'])
            ->from('mempool')
            ->innerJoin('wallet sender_wallet', 'sender_wallet.public_address = mempool.sender_address')
            ->innerJoin('wallet receiver_wallet', 'receiver_wallet.public_address = mempool.receiver_address')
            ->innerJoin('user sender_user', 'sender_wallet.user_id = sender_user.id')
            ->innerJoin('user receiver_user', 'receiver_wallet.user_id = receiver_user.id')
            ->innerJoin('profile sender', 'sender.user_id = sender_user.id')
            ->innerJoin('profile receiver', 'receiver.user_id = receiver_user.id')
            ->where(['mempool.sender_address' => $getMyAddress->public_address])
            ->orWhere(['mempool.receiver_address' => $getMyAddress->public_address])
            ->andWhere(['mempool.id' => $id])
            ->one();
    }

    public function getReceiverInfo($user_id)
    {
        return (new Query())
            ->select(['user.username', 'profile.bio', 'profile.name', 'profile.public_email', 'profile.location', 'auth_assignment.item_name'])
            ->from('profile')
            ->innerJoin('user', 'profile.user_id = user.id')
            ->innerJoin('auth_assignment', 'user.id = auth_assignment.user_id')
            ->where(['profile.user_id' => $user_id])->one();
    }

}
