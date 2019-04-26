<?php

namespace frontend\controllers;

use common\models\Profile;
use common\models\User;
use frontend\models\Mempool;
use frontend\models\search\TransactionSearch;
use frontend\models\Transaction;
use frontend\models\Wallet;
use kartik\export\ExportMenu;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\httpclient\Client;
use common\components\Helper;
use frontend\models\Node;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TransactionController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['generate-transaction', 'index','mempool','mempool-details','view','change-receiver','confirm-transaction','sign-transaction'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel  = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $columns      =
            [
            // [
            //     'label'=>'Expeditor',
            //     'attribute'=>'sender_name',
            //     'value'=>'sender.name'
            // ],
            [
                'label'=>'Expeditor',
                'attribute' => 'sender_name', 
                // 'vAlign' => 'middle',
                // 'width' => '180px',
                'value'=>'sender.name',
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
                'label'=>'Beneficiar',
                'attribute' => 'receiver_name', 
                // 'vAlign' => 'middle',
                // 'width' => '180px',
                'value'=>'receiver.name',
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
                'label'=>'Valoarea tranzacției',
                'attribute'=>'amount',
                'value'=>'amount'
            ],
            [
                'label'=>'Validată la data',
                'attribute'=>'valid_at',
                'value'=>'valid_at'
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

//        $fullExportMenu = ExportMenu::widget([
//            'dataProvider'    => $dataProvider,
//            'columns'         => $columns,
//            'target'          => ExportMenu::TARGET_BLANK,
//            'pjaxContainerId' => 'kv-pjax-container',
//            'exportContainer' => [
//                'class' => 'btn-group mr-2',
//            ],
//            'dropdownOptions' => [
//                'label'       => 'Full',
//                'class'       => 'btn btn-secondary',
//                'itemsBefore' => [
//                    '<div class="dropdown-header">Export All Data</div>',
//                ],
//            ],
//        ]);
        $layout = <<< HTML
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
        return $this->render('index', [
            'layout'         => $layout,
            'searchModel'    => $searchModel,
            'dataProvider'   => $dataProvider,
            'columns'        => $columns,
            //'fullExportMenu' => $fullExportMenu,
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing Transaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGenerateTransaction()
    {
        $walletModel = Wallet::findOne(['user_id' => Yii::$app->user->identity->id]);
        if (empty($walletModel))
        {
            Yii::$app->session->setFlash('error', ' Încă nu poți realiza o tranzacție deoarece nu deții o cheie publică si una privată. Le poți genera accesând această ' . Html::a('<u>pagină</u>', ['/wallet/index']));
            $walletModel = new Wallet();
        }
        $lastTransaction = Transaction::find()->where(['sender_address' => $walletModel->public_address])->andWhere(['status'=>'1'])->orderBy(['valid_at' => SORT_DESC])->one();        
        if (empty($lastTransaction))
        {
            $lastTransaction = new Transaction();
        }
        if(Yii::$app->request->get('id')) {
            $user_id = Yii::$app->request->get('id');
        } 
        else{
            $user_id = null;
        }  
        // $model = new Transaction();
        return $this->render('generate-transaction', [
            'walletModel' => $walletModel,
            //'model' => $model,
            'lastTransaction' => $lastTransaction,'user_id'=>$user_id]);
    }

    public function actionChangeReceiver()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost)
        {
            $user_id = Yii::$app->request->post('data');
            $model   = (new Query())
                ->select(['user.username','profile.bio', 'profile.name', 'profile.public_email', 'profile.location', 'auth_assignment.item_name'])
                ->from('profile')
                ->innerJoin('user', 'profile.user_id = user.id')
                ->innerJoin('auth_assignment', 'user.id = auth_assignment.user_id')
                ->where(['profile.user_id' => $user_id])->one();

        }

        \Yii::$app->response->data = $model;
    }

    public function actionConfirmTransaction()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $mempoolModel                = new Mempool();
        $transactionModel            = new Transaction();
        $senderWalletModel           = Wallet::findOne(['user_id' => Yii::$app->user->identity->id]);
        $receiverWalletModel         = Wallet::findOne(['user_id' => intval(Yii::$app->request->post('receiver_id'))]);
        $amount                      = floatval(Yii::$app->request->post('amount'));
        $signature                   = Yii::$app->request->post('signature');
        $sender                      = Yii::$app->request->post('sender');
        $requests                    = [];

        $getNodesResponse = Yii::$app->pandora->getHttpClient()->get('nodes/get_nodes')->send();
        if (!empty($getNodesResponse->data['nodes']) and $getNodesResponse->isOk)
        {

            // foreach (Node::find()->each() as $node)
            // {
            //     $client = new Client(['baseUrl' => 'http://' . $node->node_address, 'requestConfig' => ['format' => Client::FORMAT_JSON], 'responseConfig' => ['format' => Client::FORMAT_JSON]]);
            //     array_push($requests, $client->post('transactions/new_transaction', ['sender' => $sender, 'receiver' => $receiver->public_address, 'amount' => $amount, 'signature' => $signature]));
            // }

            // Iau toate nodurile la care este conectat respectivul utilizator si trimit tranzactia la toata lumea.
            //Helper::debug($getNodesResponse->data['nodes']);
            if ($senderWalletModel->balance < $amount)
            {
                $message = ["message" => "Nu ai suficienți bani în cont pentru a realiza tranzacția !", "type" => "danger"];
            }
            else
            {
                foreach (Node::find()->each() as $node)
                {
                    $client = new Client(['baseUrl' => 'http://' . $node->node_address, 'requestConfig' => ['format' => Client::FORMAT_JSON], 'responseConfig' => ['format' => Client::FORMAT_JSON]]);
                    array_push($requests, $client->post('transactions/new_transaction', ['sender' => $sender, 'receiver' => $receiverWalletModel->public_address, 'amount' => $amount, 'signature' => $signature]));
                }
                $newTransactionResponse = $client->batchSend($requests);

                // Scad suma de bani trimisa din portofel

                $senderWalletModel->balance = $senderWalletModel->balance - ($amount + $amount * 0.1);

                $mempoolModel->sender_address   = $sender;
                $mempoolModel->receiver_address = $receiverWalletModel->public_address;
                $mempoolModel->amount           = $amount;
                $mempoolModel->user_id          = Yii::$app->user->identity->id;
                $mempoolModel->created_at       = date('Y-m-d H:i:s');

                $transactionModel->sender_id        = Yii::$app->user->identity->id;
                $transactionModel->receiver_id      = Yii::$app->request->post('receiver_id');
                $transactionModel->amount           = floatval(Yii::$app->request->post('amount'));
                $transactionModel->created_at       = $mempoolModel->created_at;
                $transactionModel->sender_address   = Yii::$app->request->post('sender');
                $transactionModel->receiver_address = $receiverWalletModel->public_address;

                if ($mempoolModel->save() and $senderWalletModel->save() and $transactionModel->save() and $receiverWalletModel->save() and $newTransactionResponse)
                {
                    $message = ["message" => "Tranzacția dumneavoastră a fost adaugătă în tabela ". Html::a("<u>Mempool</u>",["/transaction/mempool"]) . " din rețea. Aceasta va fi validată in curând de un miner.", "type" => "success"];
                }
                else
                {
                    $message = [$transactionModel->errors, "type" => "danger"];
                }
            }

        }
        else
        {

            $message = ["message" => "Momentan nu ești conectat cu alte noduri sau ai nodul oprit, ai grijă ca acesta să fie mereu pornit cănd interacționezi cu rețeaua. Poți afla cine se află in rețeaua ta  și cum să te conectezi accesând această " . Html::a('<u>pagină</u>', ['/node/index']), "type" => "danger"];

        }

        \Yii::$app->response->data = $message;
    }

    public function actionSignTransaction()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $receiver_address            = Wallet::find()->where(['user_id' => Yii::$app->request->post('receiver_id')])->one();
        $generateTransactionResponse = Yii::$app->pandora->getHttpClient()
            ->post('transactions/generate_transaction',
                [
                    'sender'             => Yii::$app->request->post('sender'),
                    'sender_private_key' => Yii::$app->request->post('sender_private_key'),
                    'receiver'           => $receiver_address->public_address,
                    'amount'             => intval(Yii::$app->request->post('amount')),
                ])->send();
        if ($generateTransactionResponse->isOk)
        {
            Yii::$app->response->data = $generateTransactionResponse->data;
        }
        else
        {
            $message = ["message" => "Nu s-a putut semna tranzactia, ai grija ca nodul tau sa fie pornit si conectat la retea.", "type" => "danger"];
            Yii::$app->response->data = $message;
        }

    }

    public function actionMempool()
    {
        $getMyAddress            = Wallet::findOne(['user_id' => Yii::$app->user->identity->id]);
        $mempoolTransactionQuery = (new Query())
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
            

        //$mempoolTransactionQuery = $mempoolTransactionQuery->queryAll();
        // Helper::debug($mempoolTransactionQuery);
        return $this->render('mempool', ['mempoolTransactionQuery' => $mempoolTransactionQuery]);
    }

    public function actionMempoolDetails()
    {
        $myProfile    = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);
        $getMyAddress = Wallet::findOne(['user_id' => Yii::$app->user->identity->id]);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id                          = Yii::$app->request->post('id');
        $data                        = [];
        $mempoolTransactionQuery     = (new Query())
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
        //$mempoolTransactionQuery = $mempoolTransactionQuery->queryOne();
        if ($mempoolTransactionQuery['sender'] == $myProfile->name)
        {
            $username            = User::find()->innerJoin('profile', 'user.id=profile.user_id')->where(['profile.name' => $mempoolTransactionQuery['receiver']])->one()->username;
            $data['name']        = $mempoolTransactionQuery['receiver'];
            $data['role']        = "Beneficiar";
            $data['user_avatar'] = "/pandora/frontend/web/img/" . $username . "_avatar.jpg";
        }
        else
        {
            $username            = User::find()->innerJoin('profile', 'user.id=profile.user_id')->where(['profile.name' => $mempoolTransactionQuery['sender']])->one()->username;
            $data['name']        = $mempoolTransactionQuery['sender'];
            $data['role']        = "Expeditor";
            $data['user_avatar'] = "/pandora/frontend/web/img/" . $username . "_avatar.jpg";
        }
        $data['amount']            = $mempoolTransactionQuery['amount'];
        $data['created_at']        = $mempoolTransactionQuery['created_at'];
        \Yii::$app->response->data = $data;
    }
}
