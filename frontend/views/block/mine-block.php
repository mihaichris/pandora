<?php

use frontend\models\Block;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title                   = 'Minare block';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class= "container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"  data-background-color="red">
                    <h4 class="card-title"> <i class="material-icons">hourglass_empty</i> Tranzacție în așteptare</h4>
                </div>
                <div class="card-content table-responsive">
                    <table class="table table-hover">
                        <thead class="text-danger">
                            <tr>
                                <th>ID</th>
                                <th>Expeditor</th>
                                <th>Beneficiar</th>
                                <th>Suma trimisă</th>
                                <th>Creată la data de</th>
                            </tr>
                        </thead>
                    <tbody>

                    <?php $id = 1;foreach ($mempoolTransactionQuery as $transaction): ?>
                        <tr>
                        <td><?=$id++?></td>
                        <td><?=$transaction['sender']?></td>
                        <td><?=$transaction['receiver']?></td>
                        <td><?=$transaction['amount'] . "  <i  style='font-size:1em 'class='material-icons'>euro_symbol</i>"?> </td>
                        <td><?=date_format(date_create($transaction['created_at']), 'd, F Y H:i')?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row text-center">
                <div class="col-md-12">
                    <?php ActiveForm::begin()?>
                    <?=Html::submitButton(Html::img('@web/frontend/web/img/miner.png'),
    ["class"         => "btn btn-danger bmd-btn-fab",
        "id"             => "mine-block-button",
        "disabled"       => empty($mempoolTransactionQuery),
        "data-toggle"    => "tooltip",
        "data-placement" => "right",
        "title"          => "Minează un block nou."])?>
                    <?php ActiveForm::end()?>
            </div>
            </div>
            <div class="row text-center">
                <div class="col-md-12">
                    <div class="card card-stats rounded">
                        <div class="card-header" data-background-color="red">
                            <i class="material-icons">layers</i>
                        </div>
                        <div class="card-content" >
                            <p class="category">Blockuri minate</p>
                            <div id="balance">
                                <h3 class="title" ><?=Block::find()->where(['miner_id' => Yii::$app->user->identity->id])->count()?> <i class="material-icons">crop_free</i></h3>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats" data-toggle = "tooltip" data-placement = "bottom" title = "Ultimul block a fost minat la data de  <?=!empty($lastBlock) ? $lastBlock->timestamp : null?>">
                                <i class="material-icons text-danger">date_range</i> <a class="text-danger" href="#wallet">Dată minat block</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->registerCssFile("@web/frontend/web/css/block.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);?>


<?php $this->registerJsFile(
    '@web/frontend/web/js/block.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);?>