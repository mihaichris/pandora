<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;

class HashController extends \yii\web\Controller
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
                        'actions' => ['index','hash-message'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],

        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionHashMessage()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = \Yii::$app->request->post('data');
        $responseHashMessage = Yii::$app->pandora->getHttpClient()->post('block/hash',['message'=>$data])->send();
        \Yii::$app->response->data = $responseHashMessage->data;
    }
}
