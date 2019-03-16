<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Log */

$this->title = Yii::t('app', 'Error #{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-view">

    <p>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'level',
            'category',
            [
                'attribute' => 'log_time',
                'format' => 'datetime',
                'value' => (int) $model->log_time,
            ],
            'prefix',
            [
                'attribute' => 'message',
                'format' => 'html',
                'value' => Html::tag('pre', $model->message, ['style' => 'white-space: pre-wrap']),
            ],
        ],
    ]) ?>

</div>
