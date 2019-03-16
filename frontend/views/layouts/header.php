<?php

use yii\helpers\Html;

?>
    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <h3><?=Html::encode($this->title)?></h1>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">dashboard</i>
                            <p class="hidden-lg hidden-md">Dashboard</p>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">notifications</i>
                            <span class="notification">5</span>
                            <p class="hidden-lg hidden-md">Notifications</p>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Mike John responded to your email</a></li>
                            <li><a href="#">You have 5 new tasks</a></li>
                            <li><a href="#">You're now friend with Andrew</a></li>
                            <li><a href="#">Another Notification</a></li>
                            <li><a href="#">Another One</a></li>
                        </ul>
                    </li>
                    <li class ="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">person</i>
                            <p class="hidden-lg hidden-md">Profile</p>
                        </a>
                        <ul class="dropdown-menu" style="width:300px">
                            <div class="card">
                                <div class="card-header" data-background-color="orange">
                                    <div class ="card-avatar">
                                        <img class = "avatar" src=<?= file_exists(Yii::$app->basePath . "/web/img/". Yii::$app->user->identity->username ."_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/". Yii::$app->user->identity->username ."_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>
                                    </div>
                                    <?= Html::tag('p',Html::encode(Yii::$app->user->identity->username),['class'=>'text-center'])?>
                                </div>
                                <div class="card-content">
                                  <!-- CARD CONTENT-->
                                </div>
                                <div class="card-footer">
                                    <div class="pull-left">
                                        <a href="<?=Yii::$app->request->BaseUrl . '/user/settings/profile' ?>" class="btn btn-default btn-flat">Profil</a>
                                    </div>
                                    <div class="pull-right">
                                        <?= Html::a( 'Delogheaza-te', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default  btn-flat']) ?>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </li>
                </ul>

                <form class="navbar-form navbar-right" role="search">
                    <div class="form-group  is-empty">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="material-input"></span>
                    </div>
                    <button type="submit" class="btn btn-white btn-round btn-just-icon">
                        <i class="material-icons">search</i><div class="ripple-container"></div>
                    </button>
                </form>
            </div>
        </div>
    </nav>
<?php 
$this->registerCssFile("@web/frontend/web/css/layouts.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    'media' => 'print']);
?>