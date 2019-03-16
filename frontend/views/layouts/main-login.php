<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use ramosisw\CImaterial\web\MaterialAsset;
?>

<?php AppAsset::register($this);?>

<?php
if (class_exists('ramosisw\CImaterial\web\MaterialAsset'))
{
    MaterialAsset::register($this);
}
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?=Yii::$app->charset?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags()?>
    <?php $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/ico', 'href' => '../favicon.ico']); ?>
    <title><?=Html::encode($this->title)?></title>
    <?php $this->head()?>
</head>
<body class="login-page">

<?php $this->beginBody()?>

    <?=$content?>

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
