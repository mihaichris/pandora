<?php

/* @var $this yii\web\View */
/* @var $model common\models\KeyStorageItem */

$this->title = Yii::t('app', 'Update key storage item: {key}', ['key' => $model->key]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Key storage items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="key-storage-item-update">

    <?= $this->render('_form', ['model' => $model]) ?>

</div>
