<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Node */

$this->title = $query['name'];
$this->params['breadcrumbs'][] = ['label' => 'Nodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-md-offset-3 col-sm-offset-3 col-sm-6 col-md-6">
        <div class="card card-profile rounded">
            <div class ="card-avatar">
                    <img class = "avatar" src=<?= file_exists(Yii::$app->basePath . "/web/img/". $query['username']."_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/". $query['username'] ."_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>
            </div>
            <div class="content">
                <h4><?= $this->title ?></h4>
                <ul style="padding: 0; list-style: none outside none;">
                    
                    <li>
                        <i class="glyphicon glyphicon-user text-muted"></i> <span class="badge badge-pill badge-danger"><?= Html::encode($query['role']) ?></span>                        
                    </li>
                   
                   
                        <li>
                            <i class="glyphicon glyphicon-map-marker text-muted"></i> <?= Html::encode($query['location']) ?>
                        </li>
               

                        <li>
                            <i class="glyphicon glyphicon-envelope text-muted"></i> <?= Html::encode($query['node_address']) ?>
                        </li>
      
                    <li>
                        <i class="glyphicon glyphicon-time text-muted"></i> <?= Html::encode($query['created_at']) ?>
                    </li>
                </ul>
                    <p><?= Html::encode($query['bio']) ?></p>
    
            </div>
        </div>
    </div>
</div>
