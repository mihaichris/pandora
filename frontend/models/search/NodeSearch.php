<?php

namespace frontend\models\search;

use frontend\models\Node;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * NodeSearch represents the model behind the search form of `frontend\models\Node`.
 */
class NodeSearch extends Node
{
    public $username;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['node_address', 'username'], 'safe'],
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
        $query = Node::find()->cache();
        try {
            $getNodesResponse = Yii::$app->pandora->getHttpClient()->get('nodes/get_nodes')->send();
            $query->andWhere(['NOT IN', "node_address", $getNodesResponse->data['nodes']]);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', ' Ai grijă ca rețeaua ta să fie pornită !');
        }
        $query->andWhere(['!=', 'user_id', Yii::$app->user->identity->id]);
        // add conditions that should always apply here
        $query->joinWith(['user']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['username'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'node_address', $this->node_address]);
        $query->andFilterWhere(['like', 'user.username', $this->username]);
        return $dataProvider;
    }

    public function getHtmlGridColumns()
    {
        return [
            [
                'attribute' => 'username',
                'value' => 'user.username',
                "label" => "Utilizator"
            ],
            [
                "value" =>"node_address",
                "attribute" => "node_address",
                "label" => "Adresa nodului",
            ],

            ['class' => 'kartik\grid\ActionColumn',
                'header' => 'Acțiuni',
                //'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="material-icons">person</i>', $url, [
                            //'data-toggle'=>"tooltip",'data-placement'=>'top','title'=>'Vezi profil.'
                        ]);
                    },
                ],
            ],
        ];
    }

    public function getGridLayout()
    {
        return <<< HTML
    <div class="card card-stats">
            <div class="card-header pull-right" data-background-color="green">
                <i class="material-icons">list_alt</i>
            </div>
            <h4 class="card-title text-right">Noduri care nu sunt conectatela nodul tău.</h4>
    <div class="float-right">
    </div>
    <div class="clearfix"></div>
    <div class="card-body">
    {items}
    {pager}
    </div>
    </div>
HTML;
    }
}
