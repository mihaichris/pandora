<?php

use yii\helpers\Html;
use frontend\models\Wallet;
use common\components\Helper;
use common\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Listarea lanțului';
$this->params['breadcrumbs'][] = 'Lanțul tau';
?>
<div id="chain-blocks">
    <?php if (!empty($genesisBlock)): ?>
    <div class="container-fluid">
        <div class="row" id="loader-row">
            <h4 class="description text-center">Se verifică rețeaua ta dacă este validă...</h4>
            <div class="col-md-6 text-center" style="margin-left: -60px;"></div>
            <div class="col-md-6">
                <div id="loader"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center">
                <h4 id="chain-valid-message" class="description"></h4><span id="icon-chain-valid-message"></span>
            </div>
        </div>
        <div class="card card-raised rounded">

            <div class="card-content">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center"
                         style="display: :inline-block; word-break: break-all">
                        <h4 class="description"><span
                                    class="text-primary">Hash-ul block-ului precedent: </span><br> <?= $genesisBlock['chain'][0]['previous_hash'] ?>
                        </h4>
                    </div>
                </div>
                <h3>Index: <?= $genesisBlock['chain'][0]['index'] ?> </h3>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="text-rose">Genesis Block</h2>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-md-6 text-left">
                        <i class="material-icons" style="font-size:1.5em">date_range</i> <span
                                style="font-size:1.5em"><?= date_format(new \DateTime($genesisBlock['chain'][0]['timestamp']), 'Y-m-d H:i:s') ?></span>
                    </div>
                    <div class="col-md-6 text-right">
                        <i class="material-icons text-info" style="font-size:1.5em">lock</i><span
                                style="font-size:1.5em">Genesis first proof: <?= $genesisBlock['chain'][0]['proof'] ?></span>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-12" style="display: :inline-block; word-break: break-all">
                        <h4 class="description"><span
                                    class="text-primary">Hash-ul blocului actual:</span><br> <?= $genesisBlock['hashes'][0] ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($genesisBlock)): ?>
            <?php array_shift($genesisBlock['chain']) ?>
            <?php foreach ($genesisBlock['chain'] as $block): ?>
                <div class="col-md-12 text-center">
                    <span class="text-info" style="font-size:5em">&#8593;</span>
                </div>
                <div class="card card-raised rounded">
                    <div class="card-content">
                        <div class="col-md-12 text-center" style="display: :inline-block; word-break: break-all">
                            <h4 class="description"><span
                                        class="text-primary">Hash-ul block-ului precedent: </span><br> <?= $block['previous_hash'] ?>
                            </h4>
                        </div>
                        <h3>Index: <?= $block['index'] ?> </h3>
                        <div class="row text-center">
                            <div class="card-avatar" style="max-width:100px;max-height:100px">

                                <img src=<?= file_exists(Yii::$app->basePath . "/web/img/" . end($block['transactions'])['receiver'] . "_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/" . end($block['transactions'])['receiver'] . "_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>
                            </div>

                            <h4 class="description">Miner</h4>
                            <div class="col-md-6 text-left">
                                <i class="material-icons text-info" style="font-size:1.5em">lock</i><span
                                        style="font-size:1.5em">Dovada minării block-ului: <?= $block['proof'] ? $block['proof'] : null ?></span>
                            </div>

                            <div class="col-md-6 text-right">
                                <span style="font-size:1.5em"> Răsplată: <?= end($block['transactions'])['amount'] ?></span>
                                <i class="material-icons text-success" style="font-size:1.5em">euro_symbol</i>
                            </div>
                        </div>
                        <h3><span class="text-danger">Tranzacții validate:</span></h3>
                        <?php array_pop($block['transactions']) ?>
                        <?php foreach ($block['transactions'] as $transaction): ?>
                            <?php
                            $senderModel = User::find()->innerJoin('wallet', 'wallet.user_id=user.id')->where(['wallet.public_address' => $transaction['sender']])->one();
                            $receiverModel = User::find()->innerJoin('wallet', 'wallet.user_id = user.id')->where(['wallet.public_address' => $transaction['receiver']])->one();
                            ?>
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <div class="card-avatar" style="max-width:150px;max-height:150px">
                                        <img src=<?= file_exists(Yii::$app->basePath . "/web/img/" . $senderModel->username . "_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/" . $senderModel->username . "_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>
                                    </div>
                                    <h4 class="description">Expeditor</h4>
                                </div>
                                <div class="col-md-6 text-center">
                                    <div class="card-avatar" style="max-width:150px;max-height:150px">
                                        <img src=<?= file_exists(Yii::$app->basePath . "/web/img/" . $receiverModel->username . "_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/" . $receiverModel->username . "_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>
                                    </div>
                                    <h4 class="description">Beneficiar</h4>
                                </div>
                            </div>
                            <div class="card-footer">
                                <!-- <div class="col-md-6 text-center">
                <i class="material-icons" style="font-size:1.5em">date_range</i> <span style="font-size:1.5em"><?php //$transaction['transaction_created_at'] ? $transaction['transaction_created_at'] : null?></span>
            </div> -->
                                <div class="col-md-12 text-center">
                                    <i class="material-icons" style="font-size:1.5em">euro_symbol</i> <span
                                            style="font-size:1.5em"> <?= $transaction['amount'] ?></span>
                                </div>
                            </div>
                            <br><br>
                        <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <i class="material-icons" style="font-size:1.5em">date_range</i> <span
                                    style="font-size:1.5em">Minat la data de: <?= date_format(new \DateTime($block['timestamp']), 'Y-m-d H:i:s') ?></span>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div class="row text-center">
                            <div class="col-md-12" style="display: :inline-block; word-break: break-all">
                                <h4 class="description"><span
                                            class="text-primary">Hash-ul blocului actual minat:</span><br> <?= $genesisBlock['hashes'][$block['index'] - 1] ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php $this->registerJsFile(
    '@web/frontend/web/js/chain.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
); ?>

<?php $this->registerCssFile('@web/frontend/web/css/chain.css',
    ['depends' => [\yii\bootstrap\BootstrapAsset::class]]) ?>
