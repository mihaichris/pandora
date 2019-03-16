<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $searchModel frontend\models\search\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Istoric tranzacții';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transaction-index">
<?=ExportMenu::widget([
    'dataProvider'    => $dataProvider,
    'columns'         => $columns,
    'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-info',
    ],
]) . "<hr>\n"?>

    <?php Pjax::begin();?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?=GridView::widget([
    'id'           => 'transaction-grid',
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout'       => $layout,
    'toolbar'      => [
        '{export}',
    ],
    'export'       => [
        'fontAwesome' => true,
    ],
    'panel'        => [
        //'type' => GridView::TYPE_PRIMARY,
    ],
    'columns'      => $columns,
    'bordered'     => false,
    'responsive'   => true,
    'hover'        => true,
]);?>
    <?php Pjax::end();?>
</div>
