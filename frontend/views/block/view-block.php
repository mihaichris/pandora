<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Block */

$this->title = "Block Nr." .  $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-raised rounded">
    <div class="card-content">
        <h3>Index: <?=$queryBlockInfo[0]['block_index'] + 1?> </h3>
        <div class="row text-center">
            <div class ="card-avatar" style="max-width:100px;max-height:100px">
                <img  src=<?= file_exists(Yii::$app->basePath . "/web/img/". $queryBlockInfo[0]['miner_username'] ."_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/". $queryBlockInfo[0]['miner_username'] ."_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>    
            </div>
            <h4 class="description">Miner</h4>
            <div class="col-md-6 text-left">
                <i class="material-icons text-info" style="font-size:1.5em">lock</i><span style="font-size:1.5em">Dovada minării block-ului: <?=$queryBlockInfo[0]['proof_of_work']?></span>
            </div>

            <div class="col-md-6 text-right">
                <span style="font-size:1.5em"> Răsplată: <?=$queryBlockInfo[0]['fees']?></span> <i class="material-icons text-success" style="font-size:1.5em">attach_money</i>
            </div>
        </div>
        <h3><span class="text-danger">Tranzacții minate:</span></h3>
       <?php foreach($queryBlockInfo as $blockInfo):?>
       <div class="row">
            <div class="col-md-6 text-center">
                <div class ="card-avatar" style="max-width:150px;max-height:150px">
                    <img  src=<?= file_exists(Yii::$app->basePath . "/web/img/". $blockInfo['sender_username'] ."_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/". $blockInfo['sender_username'] ."_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>            
                </div>
                <h4 class="description">Expeditor</h4>
            </div>
            <div class="col-md-6 text-center">
                <div class ="card-avatar" style="max-width:150px;max-height:150px">
                    <img  src=<?= file_exists(Yii::$app->basePath . "/web/img/". $blockInfo['receiver_username'] ."_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/". $blockInfo['receiver_username'] ."_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>                        
                </div>
            <h4 class="description">Beneficiar</h4>
            </div> 
       </div>
       <div class="card-footer">
            <div class="col-md-6 text-center">
                <i class="material-icons" style="font-size:1.5em">date_range</i> <span style="font-size:1.5em"><?=$blockInfo['transaction_created_at']?></span>
            </div>
            <div class="col-md-6 text-center">
                <i class="material-icons" style="font-size:1.5em">attach_money</i> <span style="font-size:1.5em"> <?=$blockInfo['transaction_amount']?></span>
            </div>
        </div>
        <br><br>
      <?php endforeach;?>
    </div>
    <div class="row">
            <div class="col-md-12 text-center">
                <h4 class="description"><span class="text-primary">Hash-ul block-ului precedent: </span><br> <?= $queryBlockInfo[0]['previous_block_hash'] ?> </h4>
            </div>
        </div>   
    <div class="row text-center">
        <div class="col-md-12 text-center">
            <h4 class="description"><span class="text-primary">Hash-ul blocului actual minat:</span><br>  <?= $queryBlockInfo[0]['block_hash'] ?> </h4>  
        </div>
    </div>
</div>