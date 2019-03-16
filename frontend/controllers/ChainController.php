<?php

namespace frontend\controllers;

use Yii;
use yii\db\Query;

class ChainController extends \yii\web\Controller
{
    public function actionIndex()
    {
        try {
            $genesisBlock = Yii::$app->pandora->getHttpClient()->get('chain/get_chain')->send()->data;

        }
        catch (\Exception $e)
        {
            Yii::$app->session->setFlash('error', ' Ai grijă ca rețeaua ta să fie pornită !');
            $genesisBlock = [];
        }

        // $queryChainInfo = (new Query())
        //     ->select(['block.*',
        //         'hash.hash as block_hash',
        //         'user.username as miner_username',
        //         'profile.name as miner_name'])
        //     ->from('block')
        //     ->innerJoin('hash', 'hash.block_id=block.id')
        //     ->innerJoin('user', 'user.id=block.miner_id')
        //     ->innerJoin('profile', 'profile.user_id=block.miner_id')
        //     ->all();

        // for ($i = 0; $i < sizeof($queryChainInfo); $i++)
        // {
        //     $queryTransactionsInfo = (new Query())
        //         ->select(['sender_user.username as sender_username',
        //             'receiver_user.username as receiver_username',
        //             'sender.name as sender_name',
        //             'receiver.name as receiver_name',
        //             'transaction.amount as transaction_amount',
        //             'transaction.created_at as transaction_created_at'])
        //         ->from('transaction')
        //         ->innerJoin('user receiver_user', 'receiver_user.id=transaction.receiver_id')
        //         ->innerJoin('user sender_user', 'sender_user.id=transaction.sender_id')
        //         ->innerJoin('profile receiver', 'receiver.user_id=receiver_user.id')
        //         ->innerJoin('profile sender', 'sender.user_id=sender_user.id')
        //         ->where(['transaction.block_id' => $queryChainInfo[$i]['id']])
        //         ->all();
        //     $queryChainInfo[$i]['transactions'] = $queryTransactionsInfo;
        // }
        //Helper::debug($queryChainInfo);
        return $this->render('index', ['genesisBlock' => $genesisBlock]);
    }
}
