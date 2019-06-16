<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\NodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nodes';
$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-pricing card-raised">
                    <div class="card-content">
                        <h6 class="category">Conexiunea cu alte noduri <i class="material-icons text-rose">timeline</i>
                        </h6>
                        <span class="pull-right" data-toggle="tooltip" data-placement="right"
                              title="Dacă sunt noduri pe care le cunoști si nu se află in sistemul acestei aplicații, te poți conecta introducând nodul lor, eg. 127.0.0.1:port.">
                            <a href="#">
                                <i class="material-icons text-success">info</i>
                            <div class="ripple-container"></div></a>
                        </span>
                        <?= Html::input('text', 'node', '', [
                            'class' => 'form-control',
                            'placeholder' => "Introdu un nod nou",
                            "id" => "node-input"]) ?>
                        <?= Html::button('Adaugă nod', ['class' => 'btn btn-success btn-sm', 'id' => 'add-node_button']); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="connected-nodes_grid">
                    <div class="card">
                        <div class="card-header" data-background-color="green">
                    <span class="pull-right">
                    <?= Html::a('<i class="material-icons">compare_arrows</i>', ['/node/merge-nodes'], ['method' => 'POST', 'id' => 'merge_nodes', 'data-toggle' => "tooltip", 'data-placement' => 'top', 'title' => 'Combină nodurile din aplicatie cu nodurile tale.']) ?>
                        
                    <div class="ripple-container"></div>
                        </a>
                </span>
                            <h4 class="card-title">Noduri conectate</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="table table-hover">
                                <thead class="text-success">
                                <tr>
                                    <th>Node</th>
                                    <th></th>
                                    <th></th>
                                    <th>Acțiuni</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($getNodesResponse as $node): ?>
                                    <tr>
                                        <td><?= $node ?></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <?= Html::a('<i class="material-icons">close</i>
                            <div class="ripple-container"></div>', ['node/remove-node', 'node' => $node], ['class' => 'text-danger', 'id' => 'remove_node', 'data-toggle' => "tooltip", 'data-placement' => 'top', 'title' => 'Elimină nodul din reteaua ta.']); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <?= GridView::widget([
                    'id' => 'transaction-grid',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => $layout,
                    'toolbar' => [
                        '{export}',
                    ],
                    'export' => [
                        'fontAwesome' => true,
                    ],
                    'panel' => [
                        //'type' => GridView::TYPE_PRIMARY,
                    ],
                    'columns' => $columns,
                    'bordered' => false,
                    'responsive' => true,
                    'hover' => true,
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
<?php $this->registerJsFile(
    '@web/frontend/web/js/node.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
); ?>