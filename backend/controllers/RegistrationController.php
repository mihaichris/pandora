<?php

namespace backend\controllers;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;

use Yii;
use dektrium\user\Finder;
use dektrium\user\models\RegistrationForm;
use dektrium\user\models\ResendForm;
use dektrium\user\models\User;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;


class RegistrationController extends BaseRegistrationController
{
    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise
     * redirects to home page.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** 
         * @var RegistrationForm $model 
         */
        $model = \Yii::createObject(RegistrationForm::class);
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);
        
        $this->performAjaxValidation($model);
        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            $this->trigger(self::EVENT_AFTER_REGISTER, $event);
            return $this->render('/message', [
                'title'  => \Yii::t('user', 'Your account has been created and a message with further instructions has been sent to your email'),
                'module' => $this->module,
            ]);
        }

        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
}
