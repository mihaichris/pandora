<?php

namespace frontend\controllers;

use frontend\models\Block;
use frontend\models\Hash;
use frontend\models\Mempool;
use frontend\models\Node;
use frontend\models\Transaction;
use frontend\models\Wallet;
use Yii;
use yii\db\Query;
use yii\httpclient\Client;

class BlockController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMineBlock()
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
            // ->where(['mempool.sender_address' => $getMyAddress->public_address])
            // ->orWhere(['mempool.receiver_address' => $getMyAddress->public_address])
            ->all();
        $lastBlock = Block::find('timestamp')->where(['miner_id' => Yii::$app->user->identity->id])->orderBy(['timestamp' => SORT_DESC])->one();
        if (Yii::$app->request->post())
        {
            $block        = new Block();
            $time         = new \DateTime();
            $hash         = new Hash();
            $requests     = [];
            $minersWallet = Wallet::findOne(['user_id' => Yii::$app->user->identity->id]);
            if (empty(Mempool::find()->asArray()->all()))
            {
                Yii::$app->session->setFlash('error', ' Nu sunt tranzacții de validat');
            }
            else
            {
                Mempool::deleteAll();
                $mineBlockResponse = Yii::$app->pandora->getHttpClient()->get('/block/mine_block')->send();


                // Inlocuieste toate nodurile din retea


                if ($mineBlockResponse->isOk)
                {
                    foreach (Node::find()->where(['!=', 'user_id', Yii::$app->user->identity->id])->each() as $node)
                    {
                        $client = new Client(['baseUrl' => 'http://' . $node->node_address, 'requestConfig' => ['format' => Client::FORMAT_JSON], 'responseConfig' => ['format' => Client::FORMAT_JSON]]);
                        array_push($requests,$client->get('nodes/replace_chain'));
                    }

                    $replaceChainsResponse = $client->batchSend($requests);
                    $blockResponse = $mineBlockResponse->data;

                    $block->timestamp     = $blockResponse['timestamp'];
                    $block->previous_hash = $blockResponse['previous_hash'];
                    $block->miner_id      = Yii::$app->user->identity->id;
                    $block->fees          = end($blockResponse['transactions'])['amount'];
                    $block->proof_of_work = $blockResponse['proof'];

                    if ($block->save())
                    {
                        $minersWallet->balance = $minersWallet->balance + $block->fees;
                        $minersWallet->save();

                        $hash->block_id = $block->id;
                        $hash->hash     = $blockResponse['hash'];
                        $hash->save();

                        // Trimti banii la toti cei care erau senderi si nu au primit inca banii tranzactiei
                        foreach (Transaction::find()->where(['status' => '0'])->each() as $transaction)
                        {
                            $receiverWallet          = Wallet::findOne(['user_id' => $transaction->receiver_id]);
                            $receiverWallet->balance = $receiverWallet->balance + $transaction->amount;
                            $receiverWallet->save();
                        }
                        Transaction::updateAll(['status' => '1', 'valid_at' => $time->format('Y-m-d H:i:s'), 'block_id' => $block->id], ['status' => '0']);

                        return $this->redirect(['view-block', 'id' => $block->id]);
                    }
                }

            }
        }
        return $this->render('mine-block', ['mempoolTransactionQuery' => $mempoolTransactionQuery, 'lastBlock' => $lastBlock]);
    }
    public function actionViewBlock($id)
    {
        $queryBlockInfo = (new Query())
            ->select(['block.id as block_index',
                'miner_user.username as miner_username',
                'sender_user.username as sender_username',
                'receiver_user.username as receiver_username',
                'miner.name as miner_name',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'block.fees',
                'block.proof_of_work',
                'block.timestamp',
                'transaction.amount as transaction_amount',
                'transaction.created_at as transaction_created_at',
                'hash.hash as block_hash',
                'block.previous_hash as previous_block_hash'])
            ->from('transaction')
            ->innerJoin('block', 'block.id = transaction.block_id')
            ->innerJoin('user miner_user', 'miner_user.id=block.miner_id')
            ->innerJoin('user receiver_user', 'receiver_user.id=transaction.receiver_id')
            ->innerJoin('user sender_user', 'sender_user.id=transaction.sender_id')
            ->innerJoin('profile miner', 'miner.user_id=miner_user.id')
            ->innerJoin('profile receiver', 'receiver.user_id=receiver_user.id')
            ->innerJoin('profile sender', 'sender.user_id=sender_user.id')
            ->innerJoin('hash', 'hash.block_id=block.id')
            ->where(['block.id' => $id])
            ->all();
        //Helper::debug($queryBlockInfo);
        return $this->render('view-block', [
            'model'          => $this->findModel($id),
            'queryBlockInfo' => $queryBlockInfo,
        ]);
    }

    /**
     * Finds the Block model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Block the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Block::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
