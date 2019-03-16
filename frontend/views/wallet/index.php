<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title = 'Portofel';
$this->params['breadcrumbs'][] = $this->title;

?>


<div class= "container-fluid">
    <div class="row">
        <div class="col-md-8">
       <?php $form = ActiveForm::begin(['id' => 'wallet-form','options' => ['class' => 'form-horizontal'],]) ?>
            <?= $form->field($model, 'private_address')->textarea(['rows' => '9','value'=>'','readonly'=>true])->label("Cheie privată",['class'=>'text-warning']) ?>
            <?= $form->field($model, 'public_address')->textarea(['rows' => '4','value'=>'','readonly'=>true])->label("Cheia publică",['class'=>'text-warning']) ?>
            <?= Html::submitButton('Confirma noile chei', 
            ['class' => 'btn btn-warning', 'name' => 'wallet-button',"id"=>"confirm-wallet-button",
            "data-toggle"=>"tooltip", 
            "data-placement"=>"right", 
            "title"=>"Confirma cheile generate."]) ?>
        <?php ActiveForm::end() ?>
        </div>
        <div class="col-md-4">
            <div class="row text-center">
                <div class="col-md-12">
                    <?= Html::button("<i class='material-icons' style='font-size:4em'>account_balance_wallet</i>",
                    ["class"=>"btn btn-warning bmd-btn-fab" ,
                    "id"=>"generate-wallet-button", 
                    "data-toggle"=>"tooltip", 
                    "data-placement"=>"right", 
                    "title"=>"Genereaza un portofel nou."])?>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-12">
                    <div class="card card-stats rounded">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">account_balance</i>
                        </div>
                        <div class="card-content" >
                            <p class="category">Depozit curent</p>
                            <div id="balance">
                                <h3 class="title" ><?= $model->balance? $model->balance : null ?> <i class="material-icons">euro_symbol</i></h3>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats" data-toggle = "tooltip" data-placement = "bottom" title = "Ultimul portofel a fost creat la data de  <?= date_format(date_create($model->created_at),'d, F Y H:i')?>">
                                <i class="material-icons text-warning">date_range</i> <a class="text-warning" href="#wallet">Dată generat portofel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <div class="card card-nav-tabs">
        <div class="card-header" data-background-color="orange">
            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                    <span class="nav-tabs-title">Cheile tale:</span>
                    <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="active">
                            <a href="#card_public-key" data-toggle="tab">
                                <i class="material-icons">cloud</i>
                                Cheie Publica
                            <div class="ripple-container"></div></a>
                        </li>
                        <li class="">
                            <a href="#card_private-key" data-toggle="tab">
                                <i class="material-icons">vpn_key</i>
                                Cheie Privata
                            <div class="ripple-container"></div></a>
                        </li>
                        <?php if(!$model->isNewRecord):?>
                        <li  data-toggle="tooltip" data-placement="top" title="Adaugă bani in contul tau!">
                            <a href="#"  data-target="#add-money" data-toggle="modal">
                                <i class="material-icons">monetization_on</i>
                                Alimentează contul tău
                            <div class="ripple-container"></div></a>
                        </li>
                        <?php endif;?> 
                        <li class="pull-right" data-toggle="tooltip" data-placement="top" title="Cheia publica va fi de asemenea folosita ca si adresa proprie pentru efectuarea de tranzactii cu alti participanti la retea.">
                            <a href="#">
                                <i class="material-icons">info</i>
                            <div class="ripple-container"></div></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-content">
            <div class="tab-content">
                <div class="tab-pane active" id="card_public-key"><p style='word-wrap: break-word; width: 110em;'><?=($model->public_address)? $model->public_address : null ?></p></div>
                <div class="tab-pane" id="card_private-key"><p style='word-wrap: break-word; width: 110em;'><?=($model->private_address)? $model->private_address : null ?></p></div>
            </div>
        </div>

        </div>
        </div>
    </div>
</div>

<?php $this->registerCssFile("@web/frontend/web/css/wallet.css",[
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);?>


<?php $this->registerJsFile(
    '@web/frontend/web/js/wallet.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);?>