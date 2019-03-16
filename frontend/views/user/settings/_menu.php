<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use dektrium\user\widgets\UserMenu;

/**
 * @var dektrium\user\models\User $user
 */

$user = Yii::$app->user->identity;
?>
<div class="card card-signup">
    <div class="card-header card-header-primary text-center text-white">
    
        <div class="panel-heading">
            <h3 class="panel-title">
                <?= $user->username ?>
            </h3>
        </div>
        </div>

        <div class="panel-body">
            <?= UserMenu::widget() ?>
        </div>
    </div>

    <?php 
    $this->registerCss('
    .card-header-primary{
    background-color:#9C27B0 !important;
    }
    .text-white
    {
        color:white;
    }
    ');
    
    ?>