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

<!-- <?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?> -->

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="card card-signup rounded">    
                <div class="card-header card-header-primary text-center">
                    <?= Html::tag('h4',Html::encode('Login'),['class'=>"card-title text-light"])?>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'validateOnBlur' => false,
                        'validateOnType' => false,
                        'validateOnChange' => false,
                    ]) ?>
                    
                        <?= Html::tag('p','Welcome to the future',['class'=>'description text-center','style'=>'padding-top:1em'])?>
                        
                            <?php if ($module->debug): ?>
                                <?= $form->field($model, 'login', [
                                    'inputOptions' => [
                                        'autofocus' => 'autofocus',
                                        'class' => 'form-control',
                                        'tabindex' => '1'],
                                        'template' => "<div class='input-group'><span class='input-group-addon'><i class='material-icons'>face</i></span>{input}</div>"])->dropDownList(LoginForm::loginList());
                                ?>

                            <?php else: ?>
                                <?= $form->field($model, 'login',
                                    ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'placeholder' =>'Username'],
                                    'template' => "<div class='input-group'><span class='input-group-addon'><i class='material-icons'>face</i></span>{input}</div>{error}{hint}"] )->label(false);
                                ?>

                            <?php endif ?>

                            <?php if ($module->debug): ?>
                                <div class="alert alert-warning">
                                    <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                                </div>
                            <?php else: ?>
                                <?= $form->field(
                                    $model,
                                    'password',
                                    ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => $model->getAttributeLabel('password')],
                                    'template' => "<div class='input-group'><span class='input-group-addon'><i class='material-icons'>lock_outline</i></span>{input}</div>{error}{hint}"])
                                    ->passwordInput()
                                    ->label(false) ?>
                            <?php endif; ?>
            
                            <!-- <?= $form->field($model, 'rememberMe',[])->checkbox(['tabindex' => '3','class'=>"form-check-input"]) ?> -->
                               
                           
                            <?= Html::submitButton( 
                                Yii::t('user', 'Login'),
                                ['class' => 'btn  btn-info btn-block  btn-round ', 'tabindex' => '4']
                            ) ?>
                            <?php if ($module->enableConfirmation): ?>
                                <p class="text-center">
                                    <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
                                </p>
                            <?php endif ?>
                            <?php if ($module->enableRegistration): ?>
                                <p class="text-center">
                                    <?= Html::a(Yii::t('user', 'Nu ai un cont? Înregistrează-te!'), ['/user/registration/register'],['class'=>'text-info'])  . '<br>'?>
                                    <?= ($module->enablePasswordRecovery) ?  Html::a( Yii::t('user', 'Ai uitat parola?'),['/user/recovery/request'],['tabindex' => '5','class'=>'text-info']) : ''?>
                                </p>
                            <?php endif ?>
                            <?= Connect::widget([
                                'baseAuthUrl' => ['/user/security/auth'],
                            ]) ?>
                          
                        <?php ActiveForm::end(); ?>
                    </div> 
            </div>    
        </div>
    </div>
</div>
<?php $this->registerCssFile('@web/frontend/web/css/login.css',['depends' => [\yii\bootstrap\BootstrapAsset::className()]])?>