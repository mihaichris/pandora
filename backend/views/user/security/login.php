<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'class' => 'm-login__form m-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'validateOnBlur' => false,
    'validateOnType' => false,
    'validateOnChange' => false,
]) ?>
<?= (Yii::$app->session->getFlash('success') ) ? Yii::$app->session->getFlash('success') : '' ?>
<?php if ($module->debug): ?>
    <div class="form-group m-form__group">
        <?= $form->field($model, 'login', [
            'inputOptions' => [
                'autofocus' => 'autofocus',
                'class' => 'form-control m-input',
                'tabindex' => '1']])->dropDownList(LoginForm::loginList());
        ?>
    </div>
<?php else: ?>
    <div class="form-group m-form__group">
        <?= $form->field($model, 'login',
            ['inputOptions' => ['autofocus' => 'autofocus', 'placeholder' => 'Uername' ,'class' => 'form-control m-input', 'tabindex' => '1']]
        );
        ?>
    </div>
<?php endif ?>

<?php if ($module->debug): ?>
    <div class="alert alert-warning">
        <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
    </div>
<?php else: ?>
    <div class="form-group m-form__group">
        <?= $form->field(
            $model,
            'password',
            ['inputOptions' => ['class' => 'form-control m-input', 'placeholder' => 'Password' ,'tabindex' => '2']])
            ->passwordInput()
            ->label(
                Yii::t('user', 'Password')
                . ($module->enablePasswordRecovery ?
                    ' (' . Html::a(
                        Yii::t('user', 'Forgot password?'),
                        ['/user/recovery/request'],
                        ['tabindex' => '5']
                    )
                    . ')' : '')
            ) ?>
    </div>
<?php endif ?>

<div class="row form-group m-form__group m-login__form-sub">
    <div class="col m--align-left">
        <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3', 'class'=>'m-checkbox m-checkbox--focus']) ?>
    </div>
</div>


<div class="m-login__form-action">
    <?= Html::submitButton(
        Yii::t('user', 'Sign in'),
        ['class' => 'btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn', 'tabindex' => '4']
    ) ?>
</div>

<?php ActiveForm::end(); ?>

<div class="m-login__account">
<?php if ($module->enableConfirmation): ?>
    <span class="m-login__account-msg">
        <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
    </span>
<?php endif ?>
    &nbsp;&nbsp;
<?php if ($module->enableRegistration): ?>
    <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register'], ['class' => 'm-link m-link--light m-login__account-link']) ?>
<?php endif ?>
</div>

