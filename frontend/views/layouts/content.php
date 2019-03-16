<?php 

use yii\widgets\Breadcrumbs;
use ramosisw\CImaterial\widgets\Alert;
?>

<div class="content">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options'=>['style'=>'text-align:right','class'=>'breadcrumb']
    ]) ?>
    <?= Alert::widget() ?>
        <?= $content ?>
</div>