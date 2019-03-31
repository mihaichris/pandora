<?php
namespace frontend\controllers;

use frontend\models\Node;
use frontend\models\search\NodeSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\db\Query;
use common\components\Helper;

/**
 * NodeController implements the CRUD actions for Node model.
 */
class NodeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','view','merge-nodes','remove-node','add-node'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Node models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel      = new NodeSearch();
        $dataProvider     = $searchModel->search(Yii::$app->request->queryParams);
        $getNodesResponse = [];
        $columns          =
            [
            [
                'attribute' => 'username',
                'value'     => 'user.username',
            ],
            "node_address",

            ['class'        => 'kartik\grid\ActionColumn',
                'header'        => 'Actions',
                //'headerOptions' => ['style' => 'color:#337ab7'],
                'template'      => '{view}',
                'buttons'       => [
                    'view'   => function ($url, $model)
                    {
                        return Html::a('<i class="material-icons">person</i>', $url, [
                            //'data-toggle'=>"tooltip",'data-placement'=>'top','title'=>'Vezi profil.'
                        ]);
                    },
                ],
            ],
        ];
        $layout = <<< HTML
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
        try
        {
            $getNodesResponse = (Yii::$app->pandora->getHttpClient()->get('nodes/get_nodes')->send())->data['nodes'];
        }
        catch (\Exception $e)
        {
            Yii::$app->session->setFlash('error', ' Ai grijă ca rețeaua ta să fie pornită !');
        }
        return $this->render('index', [
            'searchModel'      => $searchModel,
            'dataProvider'     => $dataProvider,
            'layout'           => $layout,
            'columns'          => $columns,
            'getNodesResponse' => $getNodesResponse,
        ]);
    }

    /**
     * Displays a single Node model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = (new Query())->select(['user.username','profile.public_email as email','profile.bio','profile.name','profile.location','node.node_address','auth_assignment.item_name as role','FROM_UNIXTIME(user.created_at) as created_at'])
                ->from('node')
                ->innerJoin('user','user.id=node.user_id')
                ->innerJoin('profile','profile.user_id=user.id')
                ->innerJoin('auth_assignment','auth_assignment.user_id=user.id')
                ->where(['node.user_id'=> $model->user_id])
                ->one();
        //Helper::debug($query->createCommand()->getRawSql());
        return $this->render('view', [
            'query' => $query,
        ]);
    }

    /**
     * Finds the Node model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Node the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Node::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMergeNodes()
    {
        $nodesArray = [];

        foreach (Node::find()->where(['!=', 'user_id', Yii::$app->user->identity->id])->each() as $node)
        {
            array_push($nodesArray, 'http://' . $node->node_address);
        }
        $getNodesResponse = Yii::$app->pandora->getHttpClient()->post('nodes/connect_nodes', ['nodes' => $nodesArray])->send();

        if ($getNodesResponse->isOk)
        {
            Yii::$app->session->setFlash('success', ' Toate nodurile sunt conectate !');
        }
        else
        {
            Yii::$app->session->setFlash('error', ' Opss, a apărut o eroare la conectarea nodurilor!');
        }
        $this->redirect('index');
    }

    public function actionRemoveNode($node)
    {
        $myNode = Node::findOne(['user_id' => Yii::$app->user->identity->id]);
        $client = new Client(['baseUrl' => 'http://' . $node, 'responseConfig' => ['format' => Client::FORMAT_JSON]]);

        $getRemoveNodeResponse   = Yii::$app->pandora->getHttpClient()->delete('nodes/remove_node/' . $node)->send();
        $getRemoveMyNodeResponse = $client->delete('nodes/remove_node/' . $myNode->node_address)->send();

        if ($getRemoveNodeResponse->isOk and $getRemoveMyNodeResponse->isOk)
        {
            Yii::$app->session->setFlash('success', ' Nodul ' . $node . ' a fost șters cu succes !');
        }
        else
        {
            Yii::$app->session->setFlash('error', ' Opss, a apărut o eroare la ștergerea nodului!');
        }
        $this->redirect('index');
    }

    public function actionAddNode()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $node                        = ['http://' . trim(Yii::$app->request->post('node'))];
        $getConnectNodeResponse = Yii::$app->pandora->getHttpClient()->post('nodes/connect_nodes', ['nodes' => $node])->send();

        if ($getConnectNodeResponse->isOk)
        {
            $message = ["message" => "Nodul a fost ădaugat cu succes in rețeaua ta.", "type" => "success"];
        }
        else
        {
            $message = ["message" => "Opss, a apărut o eroare la adăugarea nodului.", "type" => "danger"];
        }
        \Yii::$app->response->data = $message;
    }
}
