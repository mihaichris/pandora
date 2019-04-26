<?php

namespace frontend\controllers;

use Yii;
use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;

class AdminController extends BaseAdminController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'subscribe' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['switch'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }
}
