<?php

namespace frontend\controllers;

use DateTime;
use frontend\models\Wallet;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\components\Helper;

class WalletController extends \yii\web\Controller
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
                        'actions' => ['index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $time  = new DateTime();
        $model = Wallet::findOne(['user_id' => Yii::$app->user->identity->id]);
        //Helper::debug($model);
        if (empty($model))
        {
            $model = new Wallet();
        }
        if ($model->load(Yii::$app->request->post()))
        {
            $model->user_id    = Yii::$app->user->identity->id;
            $model->created_at = $time->format('Y-m-d H:i:s');

            if ($model->validate() and $model->save())
            {
                Yii::$app->session->setFlash('success', ' Portofelul tau nou a fost inregistrat.');
            }
            else
            {
                Yii::$app->session->setFlash('error', ' A aparut o eroare la inregistrarea noului portofel.');
            }

            return $this->refresh();
        }
        return $this->render('index', ['model' => $model]);
    }

    public function actionAddBalance()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $model          = Wallet::findOne(['user_id' => Yii::$app->user->identity->id]);
        $depositAmount = Yii::$app->request->post('data');
        if(!empty($depositAmount) and is_numeric($depositAmount))
        {
            $model->balance = $model->balance + $depositAmount;
            if($model->save())
            {
                $message = ["message"=>"Suma oferită a fost adăugată în portofelul tău.","type"=>"success"];
            }
            else
            {
                $message = ["message"=>"Suma nu a putut fi adăugată în portofel. Posibilă o eroare la procesarea sumei.","type"=>"danger"];
            }
        }
        else
        {
            $message = ["message"=>"Valoarea oferită nu este una validă.","type"=>"danger"];
        }  
        \Yii::$app->response->data = $message;
    }

    public function actionGenerateWallet()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $generateWalletResponse = Yii::$app->pandora->getHttpClient()->get('wallet/new_wallet')->send();
        $setReceiverResponse    = Yii::$app->pandora->getHttpClient()->post('user/set_receiver', ['receiver' => $generateWalletResponse->data['public_key']])->send();

        \Yii::$app->response->data = $generateWalletResponse->data;
    }

}
