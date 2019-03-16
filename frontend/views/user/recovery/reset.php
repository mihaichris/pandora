<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\RecoveryForm $model
 */

$this->title = Yii::t('user', 'Reset your password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="card card-signup rounded"> 
                <div class="card-header card-header-primary text-center">
                    <?= Html::tag('h4',Html::encode('Reset your password'),['class'=>"card-title text-light"])?>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'password-recovery-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                    ]); ?>

                   <?= $form->field(  $model, 'password',  
                    ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => $model->getAttributeLabel('password')],
                    'template' => "<div class='input-group'><span class='input-group-addon'><i class='material-icons'>lock_outline</i></span>{input}</div>{error}{hint}"])
                    ->passwordInput()
                    ->label(false) ?>

                    <?= Html::submitButton(Yii::t('user', 'Finish'), ['class' => 'btn btn-success btn-block']) ?><br>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerCssFile('@web/frontend/web/css/reset.css',['depends' => [\yii\bootstrap\BootstrapAsset::className()]])?>