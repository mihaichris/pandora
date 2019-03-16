<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

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
                'only'  => ['logout', 'signup', 'index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                    [
                        'actions' => ['captcha'],
                        'allow'   => true,
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
