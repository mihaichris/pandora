<?php

use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use common\components\Helper;

/* @var $searchModel frontend\models\search\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tranzacții în așteptare';
$this->params['breadcrumbs'][] = $this->title;
//  Helper::debug(\Yii::$app->cache);
?>

    <div class="container-fluid">
        <div class="row">
            <div class=" col-md-offset-1 col-md-4">
                <div id="mempool_profile" style="display: none;">
                    <div class="card card-profile rounded">
                        <div class="image">
                            <img src=<?= Yii::getAlias('@web') . "/frontend/web/img/city_wallpaper.jpg" ?>>
                        </div>
                        <div class="card-avatar">
                            <img class="avatar" id="change-user_avatar"
                                 src=<?= file_exists(Yii::$app->basePath . "/web/img/" . Yii::$app->user->identity->username . "_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/" . Yii::$app->user->identity->username . "_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>
                        </div>
                        <div class="content">
                            <h5 id="change-user_name"></h5>
                            <p class="description"><span id="change-user_role" class="badge badge-pill"></span></p>
                            <button id="dismiss-mempool-details_button" type="button"
                                    class="btn btn-sm btn-simple btn-danger"><i class="material-icons">clear</i>
                            </button>
                        </div>
                        <div class="card-footer">
                            <div class="col-md-6 text-center">
                                <i class="material-icons">euro_symbol</i>
                                <p id="change-user_amount"></p>
                            </div>
                            <div class="col-md-6 text-center">
                                <i class="material-icons">date_range</i>
                                <p id="change-user_created_at"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header" data-background-color="orange">
                        <h4 class="card-title"><i class="material-icons">hourglass_empty</i> Ordine în așteptare
                        </h4>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                            <tr>
                                <th>ID</th>
                                <th>Expeditor</th>
                                <th>Beneficiar</th>
                                <th>Suma trimisă</th>
                                <th>Creată la data de</th>
                                <th>Recompensă</th>
                                <th>Acțiuni</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $id = 1;
                            foreach ($mempoolTransactionQuery as $transaction): ?>
                                <tr>
                                    <td><?= $id++ ?></td>
                                    <td><?= $transaction['sender'] ?></td>
                                    <td><?= $transaction['receiver'] ?></td>
                                    <td><?= $transaction['amount'] . "  <i  style='font-size:1em 'class='material-icons'>euro_symbol</i>" ?> </td>
                                    <td><?= date_format(date_create($transaction['created_at']), 'd, F Y H:i') ?></td>
                                    <td><?= Html::button("<i class='fa fa-eye'></i>", ['class' => 'btn  btn-sm btn-simple btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informații despre tranzacție', 'onclick' => 'mempoolDetails(' . $transaction['id'] . ')']) ?></td>
                                    <td> <?= ($transaction['amount'] * 0.1) ?> </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class = "row">
            <div class="card">
                <div class="card-content">
                    <div class="col-md-4">
                        <div class="info">
                            <div class="icon icon-primary">
                                <i class="material-icons">chat</i>
                            </div>
                            <h4 class="info-title">Free Chat</h4>
                            <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info">
                            <div class="icon icon-primary text-center">
                                <i class="material-icons">chat</i>
                            </div>
                            <h4 class="info-title text-center">Free Chat</h4>
                            <p class="text-center">Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info">
                            <div class="icon icon-primary text-right">
                                <i class="material-icons">chat</i>
                            </div>
                            <h4 class="info-title text-right">Free Chat</h4>
                            <p class="text-right">Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>


<?php $this->registerJsFile(
    '@web/frontend/web/js/mempool.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
); ?>