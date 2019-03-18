<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Profile;
use kartik\number\NumberControl;
use common\components\Helper;
/* @var $this yii\web\View */
$this->title = 'Generare tranzactie';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-raised rounded ">
                <div class="card-content">
                    <h6 class="category"><i class='material-icons text-info'>work</i> Generează o tranzacție nouă <span data-toggle="tooltip" data-placement="top" title="Cheia publică si cheia privată se vor autocompleta dacă acestea există" class="pull-right"><i class='material-icons text-info'>info</i></span></h6>
                    
                        <?= Html::beginTag('div',['class'=>"form-group"]);?>
                            <?= Html::label("Adresă expeditor",'public_address',['class'=>'form-label'])?>
                            <?= Html::activeTextarea($walletModel,'public_address',['class'=>'form-control','rows' => '3','readonly'=>true])?>
                        <?= Html::endTag('div');?>
                        <?= Html::beginTag('div',['class'=>"form-group"]);?>
                            <?= Html::label("Adresă privată a expeditorului",'private_address',['class'=>'form-label'])?>
                            <?= Html::activeTextarea($walletModel,'private_address',['class'=>'form-control','rows' => '8','readonly'=>true])?>
                        <?= Html::endTag('div');?>
                        <?= Html::beginTag('div',['class'=>"form-group"]);?>
                            <?= Html::label('Adresă destinatar','receiver_address',['class'=>'form-label'])?>
                            <?= Select2::widget([
                                "id"=>"receiver_address",
                                'name'=>'receiver_address',
                                'value'=> $user_id ? $user_id : null,
                                'data' => ArrayHelper::map(Profile::find()->innerJoin('user','profile.user_id=user.id')->where(['not',"profile.name = 'Admin'"])->andWhere(['not',"user_id=" . Yii::$app->user->identity->id])->asArray()->cache()->all(),'user_id','name'),
                                'options' => ['placeholder' => 'Selecteaza beneficiarul...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);?>
                        <?= Html::endTag('div');?>
                        <?= Html::beginTag('div',['class'=>"form-group"]);?>
                            <?= Html::label("Valoare",'amount',['class'=>'form-label'])?>
                            <?= NumberControl::widget([
                                "id"=> "amount",
                                "name"=>"amount",
                                'value' => 0,
                                'displayOptions' => [
                                    'placeholder' => 'Introdu o sumă validă...',
                                    'class'=>'form-control',
                                ],
                                'maskedInputOptions' => [
                                    'prefix' => '€ ',
                                    'groupSeparator' => '.',
                                    'radixPoint' => ',',
                                    'allowZero' => true,
                                    'allowEmpty' => false,
                                    'allowMinus' => false
                                ],
                            ]);?>
                        <?= Html::endTag('div');?>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <span data-toggle="modal" data-target="#confirm-transaction-modal">
                <?= Html::button("<i class='material-icons' style='font-size:4em'>credit_card</i>",
                        ["class"=>"btn btn-info bmd-btn-fab" ,
                        "id"=>"generate-transaction-button",
                        "data-toggle"    => "tooltip",
                        "data-placement" => "right",
                        "title"          => "Genereaza o noua tranzactie.",
                        //"disabled"=> isset(Yii::$app->request->post("receiver_address")),
                        ])?>
            </span>
            <div class="card card-stats rounded">
                <div class="card-header" data-background-color="blue">
                    <i class="material-icons">work</i>
                </div>
                <div class="card-content">
                    <p class="category">Valoarea ultimei tranzacții</p>
                    <h3 class="title"> <i class="material-icons">euro_symbol</i><?= is_numeric($lastTransaction->amount)?$lastTransaction->amount:null?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats" data-toggle = "tooltip" data-placement = "bottom"
                        title = " Ultima ta tranzacție a fost validată la data de  <?= $lastTransaction->valid_at ? date_format(date_create($lastTransaction->valid_at),'d, F Y H:i'): null?>">
                        <i class="material-icons text-info">date_range</i> <a class="text-info" href="#transaction">Data ultimei tranzacții validate</a>
                    </div>
                </div>
            </div>

              <div class="card card-raised rounded" id="user-card" style="display:none">
                <div class="card-content">
                    <div class="card-avatar"  style="max-width:100px;max-height:100px">
                        <a href="#pablo">
                        <img class = "avatar" id="change-user_avatar" src=<?= Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>
                        </a>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title" id="change-user_name"></h4>
                        <h6 class="category text-muted" ><span id="change-user_role" class="badge badge-pill badge-danger"></span></h6>
                        <h6 class="category text-muted" id="change-user_public_email"></h6>
                        <p class="card-description" id="change-user_bio">
                           
                        </p>
                    </div>
               </div> 
            </div>
        </div>
    </div>
</div>


<?php $this->registerCssFile("@web/frontend/web/css/transaction.css",[
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);?>


<?php $this->registerJsFile(
    '@web/frontend/web/js/transaction.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);?>