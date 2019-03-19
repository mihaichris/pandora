<?php

use frontend\models\Transaction;
use frontend\models\Wallet;
use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row">
        <?php if (!empty($getChainResponse)): ?>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats rounded">
                    <div class="card-header" data-background-color="orange">
                        <i class="material-icons">timeline</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Marimea lanțului</p>
                        <h3 class="title"><?= sizeof($getChainResponse['chain']) ?>
                            <small><i class="material-icons">crop_free</i></small>
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <!-- <i class="material-icons text-danger">warning</i> <a href="#pablo">Get More Space...</a> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats rounded">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">account_balance</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Depozit</p>
                        <h3 class="title"><?= Wallet::findOne(['user_id' => Yii::$app->user->identity->id])->balance ?>
                            <i class="material-icons">euro_symbol</i></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <!-- <i class="material-icons">date_range</i> Last 24 Hours -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats rounded">
                    <div class="card-header" data-background-color="red">
                        <i class="material-icons">person</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Persoane conectate</p>
                        <h3 class="title"><?= sizeof($getUsersQuery) ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-danger">refresh</i> <a href="/pandora/node/index">Conectează-te
                                cu alți utilizatori ai rețelei...</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats rounded">
                    <div class="card-header" data-background-color="blue">
                        <i class="material-icons">credit_card</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Tranzactii inregistrate</p>
                        <h3 class="title"><?= sizeof(Transaction::find()->where(['sender_id' => Yii::$app->user->identity->id])->andWhere('created_at > DATE_SUB(CURDATE(), INTERVAL 1 DAY)')->all()) ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Ultimele 24 de ore
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card rounded">
                <h3 class="text-center description text-rose">Persoane care te cunosc !</h3>
                <div class="card-content">
                    <?php if (!empty($getUsersQuery)): ?>
                        <?php foreach ($getUsersQuery as $connectedUser): ?>
                            <div class="col-md-4 text-center">
                                <div class="card-avatar" style="max-width:150px;max-height:150px">
                                    <img src=<?= file_exists(Yii::$app->basePath . "/web/img/" . $connectedUser['username'] . "_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/" . $connectedUser['username'] . "_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>
                                </div>
                                <br>
                                <div class="text-center">
                                    <span class="badge bg-white"
                                          style="background-color:#02ADC2"><?= $connectedUser['item_name'] ?></span>
                                </div>
                                <h4 class="info-title text-center"><?= $connectedUser['name'] ?></h4>
                                <?= Html::a("<i class='material-icons'>credit_card</i>", ['/transaction/generate-transaction', 'id' => $connectedUser['id']], ['class' => "btn-round btn btn-outline-success btn-sm btn-info",
                                    "data-toggle" => "tooltip",
                                    "data-placement" => "bottom",
                                    "title" => "Realizează o tranzacție cu " . $connectedUser['username']]) ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card rounded">
                <h3 class="text-center description text-rose">Numărul de utiliatori pe roluri din rețea</h3>
                <div class="card-content">
                    <?= ChartJs::widget($chartUserByRoles) ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card rounded">
                <h3 class="text-center description text-rose">Evoluția rețelei de-a lungul timpului</h3>
                <h5 class="text-center description text-secondary">(Numărul de blocuri minate pe lună)</h5>
                <div class="card-content">
                    <?= ChartJs::widget($chainGrowChart) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card rounded">
                <h3 class="text-center description text-rose">Numărul total de tranzacții confirmate pe zi</h3>
                <h5 class="text-center description text-secondary"></h5>
                <div class="card-content">

                    <?= ChartJs::widget($transactionsConfirmedPerDayChart) ?>
                </div>
            </div>
        </div>
    </div>
</div>

