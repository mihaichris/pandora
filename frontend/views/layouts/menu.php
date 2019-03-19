<?php

use yii\helpers\Html;
use ramosisw\CImaterial\widgets\Menu;
use common\components\Helper;
?>
<div class="sidebar" style="background-color: #FEFEFE;" data-color=<?= $color?>>
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
        Tip 2: you can also add an image using data-image tag
    -->
   

 

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href=<?= Yii::$app->homeUrl ?> class="simple-text">
            <?= Html::img('@web/frontend/web/img/logo.png', ['class'=>'logo-pandora','alt' => Html::encode(Yii::$app->name)]) ?>
            </a>
        </div>
    
        <div class ="card-avatar">
                <img class = "avatar" src=<?= file_exists(Yii::$app->basePath . "/web/img/". Yii::$app->user->identity->username ."_avatar.jpg") ? Yii::getAlias('@web') . "/frontend/web/img/". Yii::$app->user->identity->username ."_avatar.jpg" : Yii::getAlias('@web') . "/frontend/web/img/marc.jpg" ?>>
            
        </div>
        <div class="user">
            <!--Inceput meniu pentru utilizator-->
            <?= Menu::widget(
                    [
                        'options' => ['class' => 'nav'],
                        'items' => [
                            ['label' => Yii::$app->user->identity->username,'icon'=>'person','url'=>'#', 'items' => [
                                ['label' => 'Profilul meu', 'url' => ['/user/profile']],
                                ['label' => 'Editează profilul', 'url' => ['/user/settings/profile']],
                            ]],
                        ],
                        
                    ]
                );?>
        </div>        
            <!--Sfarsit meniu pentru utilizator-->

        <!--Inceput meniu principal-->
        <?= Menu::widget(
            [
                'options' => ['class' => 'nav'],
                'items' => [
                    ['label' => 'Tablou de bord','options'=>['class'=>'active'],'icon'=>'dashboard', 'url' => ['/site/index']],
                    ['label' => 'ePortofel','options'=>['class'=>'active'],'icon'=>'account_balance_wallet', 'url' => ['/wallet/index']],
                    ['label' => 'Lanțul meu','options'=>['class'=>'active'],'icon'=>'timeline', 'url' => ['/chain/index']],
                    ['label' => 'Minare', 'icon'=>'security' ,'url'=>['/block/mine-block'], 'visible'=> Yii::$app->user->can('Miner') ],                    
                    ['label' => 'Tranzacționează', 'icon'=>'credit_card' ,'url'=>['#'], 'items' => [
                        ['label' => 'Generare tranzactie', 'icon'=>'work','url' => ['/transaction/generate-transaction']],
                        ['label' => 'Istoric tranzacții', 'icon'=>'list_alt' ,'url' => ['/transaction/index']],
                        ['label' => 'Ordinele mele', 'icon'=>'hourglass_empty' ,'url' => ['/transaction/mempool']],
                    ]],
                    ['label' => 'Documentație Hashing','options'=>['class'=>'active'],'icon'=>'code', 'url' => ['/hash/index']],
                    ['label' => 'Noduri conectate','options'=>['class'=>'active'],'icon'=>'device_hub', 'url' => ['/node/index']],
                    // 'Products' menu item will be selected as long as the route is 'product/index'
                    ['label' => 'Utilizatori', 'url'=>['#'], 'visible' => \Yii::$app->user->can('Admin'),'items' => [
                        ['label' => 'Listare utilizatori', 'url' => ['/user/admin/index']],
                    ]],
                    ['label' => 'RBAC',  'visible' => \Yii::$app->user->can('Admin'),'url'=>['#'], 'items' => [
                        ['label' => 'Permisiuni', 'url' => ['/admin/permission']],
                        ['label' => 'Rute', 'url' => ['/admin/route']],
                        ['label' => 'Roluri', 'url' => ['/admin/role']],
                        ['label' => 'Asignari', 'url' => ['/admin/assignment']],
                    ]],
                    ['label' => 'Login', 'url' => ['/site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
                
            ]
        );?>
         <!--Sfarsit meniu principal-->


        <!-- <ul class="nav">
            <li class="active">
                <a href="index">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="material-icons">person</i>
                    <p>User Profile</p>
                </a>
            </li>
            <li>
                <a href="gii">
                    <i class="material-icons">content_paste</i>
                    <p>Table List</p>
                </a>
            </li>
            <li class= "nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="typography.html">
                    <i class="material-icons">library_books</i>
                    <p>Typography</p>
                </a>
            </li>
            <li>
                <a href="icons.html">
                    <i class="material-icons">bubble_chart</i>
                    <p>Icons</p>
                </a>
            </li>
            <li>
                <a href="maps.html">
                    <i class="material-icons">location_on</i>
                    <p>Maps</p>
                </a>
            </li>
            <li>
                <a href="/notifications.html">
                    <i class="material-icons text-gray">notifications</i>
                    <p>Notifications</p>
                </a>
            </li>
            <li class="active-pro">
                <a href="upgrade.html">
                    <i class="material-icons">unarchive</i>
                    <p>Upgrade to PRO</p>
                </a>
            </li>
        </ul> -->
    </div>
</div>

<?php 
$this->registerCss('
.logo-pandora{
    max-width: 100%;
        max-height: 100%;
        height: 250px;
        width: 250;
        margin-bottom: -100px;
        margin-top: :-100px;
        margin-top: -80px;
}
');?>