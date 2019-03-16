<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use ramosisw\CImaterial\web\MaterialAsset;
use yii\helpers\Html;
use ibrarturi\scrollup\ScrollUp;

AppAsset::register($this);
if (in_array(Yii::$app->controller->action->id, ['login', 'register', 'resend', 'reset', 'request', 'error', 'confirm-role', 'confirmare-miner', 'confirmare-investitor']))
{
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render('main-login', ['content' => $content]);
}
else
{
    if (Yii::$app->controller->id == 'node')
    {
        $color = "green";
    }
    else if (Yii::$app->controller->id == 'transaction')
    {
        if (in_array(Yii::$app->controller->action->id, ['index', 'generate-transaction']))
        {
            $color = "blue";
        }
        else if (Yii::$app->controller->action->id == 'mempool')
        {
            $color = "orange";
        }
        else
        {
            $color = "purple";
        }
            
    }
    else if (Yii::$app->controller->id == 'wallet')
    {
        $color = "orange";
    }
    else if(Yii::$app->controller->id=="block")
    {
        $color = "red";
    }
    else
    {
        $color = "purple";
    }

    if (class_exists('ramosisw\CImaterial\web\MaterialAsset'))
    {
        MaterialAsset::register($this);
    }
    ?>

<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags()?>
    <?php $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/ico', 'href' => Yii::getAlias('@web/frontend/web/favicon.ico')]); ?>

    <title><?=Html::encode($this->title)?></title>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>

<div class="wrapper">
<!--LEFT MENU-->
    <?=$this->render('menu', ['color' => $color])?>

    <div class="main-panel">
        <!--NAVIGATION BAR-->
        <?=$this->render('header')?>

        <!--CONTENT-->
        <?=$this->render('content', ['content' => $content])?>


        <!--FOOTER-->
        <?=$this->render('footer')?>
    </div>
 </div>

 
<!--MODALS WILL BE ADDED HERE, OUTSIDE THE DIV.WRAPPER TAG -->
<?=$this->render('modals')?>
<!--MODALS WILL BE ADDED HERE, OUTSIDE THE DIV.WRAPPER TAG -->

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
<?php }?>