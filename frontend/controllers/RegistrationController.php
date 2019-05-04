<?php

namespace frontend\controllers;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use dektrium\user\models\RegistrationForm;
use yii\web\NotFoundHttpException;


class RegistrationController extends BaseRegistrationController
{
    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidConfigException
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
            // return $this->render('/message', [
            //     'title'  => \Yii::t('user', 'Your account has been created and a message with further instructions has been sent to your email'),
            //     'module' => $this->module,
            // ]);
            return $this->redirect(['/site/confirm-role', 'username' => $model->username]);
        }

        return $this->render('register', [
            'model' => $model,
            'module' => $this->module,
        ]);
    }
}
