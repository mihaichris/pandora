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
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;


/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="card card-signup rounded">   
                <div class="card-header card-header-primary text-center">
                    <?= Html::tag('h4',Html::encode('Register'),['class'=>"card-title text-light"])?>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'registration-form',
                        // 'enableAjaxValidation' => true,
                        // 'enableClientValidation' => false,
                    ]); ?>
                    <?= Html::tag('p','Welcome to the future',['class'=>'description text-center','style'=>'padding-top:1em'])?> 
                    <?= $form->field($model, 'email',
                    ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => $model->getAttributeLabel('email')],
                    'template' => "<div class='input-group'><span class='input-group-addon'><i class='material-icons'>mail</i></span>{input}</div>{error}{hint}"])
                    ->label(false) ?>

                    <?= $form->field($model, 'username', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => $model->getAttributeLabel('username')],
                    'template' => "<div class='input-group'><span class='input-group-addon'><i class='material-icons'>face</i></span>{input}</div>{error}{hint}"])
                    ->label(false) ?>

                    <?php if ($module->enableGeneratingPassword == false): ?>
                        <?= $form->field($model, 'password',
                         ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => $model->getAttributeLabel('password')],
                         'template' => "<div class='input-group'><span class='input-group-addon'><i class='material-icons'>lock_outline</i></span>{input}</div>{error}{hint}"])
                         ->passwordInput()->label(false) ?>
                    <?php endif ?>
                    
                    <?= $form->field($model, 'captcha',['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => $model->getAttributeLabel('captcha')],
                    'template' => "<div class='input-group'><span class='input-group-addon'><i class='material-icons'>cached</i></span>{input}</div>{error}{hint}"])->widget(Captcha::className(), [
                            'captchaAction' => ['/site/captcha']
                        ]) ?>

                    <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-primary btn-block btn-round']) ?>
                    <p class="text-center">
                        <?= Html::a(Yii::t('user', 'Ai deja un cont? Loghează-te!'), ['/user/security/login']) ?>
                     </p>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php $this->registerCssFile('@web/frontend/web/css/register.css',['depends' => [\yii\bootstrap\BootstrapAsset::className()]])?>