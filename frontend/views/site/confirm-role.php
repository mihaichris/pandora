<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Confirmare Rol';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">    
        <div id = "pills" class="col-lg-6 col-md-6">    
            <div class="card card-signup">    
                <div class="card-header card-header-warning text-center text-colored" style="background-color:#ff9933">
                    <?= Html::tag('h4',Html::encode('Miner') . Html::img('@web/frontend/web/img/miner.png',['alt'=>'Miner logo','style'=>'width:25px']),['class'=>"card-title text-bold"])?>
                </div>
                <div class="panel-body text-center">
                    <p class="text-justify">
                        Ca si miner, vei avea misiunea importanta de a mentine reteaua in picioare, folosind puterea de procesare a device-ului pe care il folosesti.
                        Vei valida tranzactiile , creea blocuri astfel dezvoland reteaua Pandora. Tot efortul depus va fi rasplatit cu moneda noastra denumita paincoin. 
                    </p>
                    <?= Html::a('Alege sa devii miner', Url::to(['/site/confirmare-miner','username'=>$username]),['id'=>"miner" , 'class'=>'btn btn-warning']) ?>
                </div>
            </div>    
         </div>   
        <div id = "pills" class="col-lg-6 col-md-6 ">    
            <div class="card card-signup">    
                <div class="card-header card-header-info text-center" style="background-color: #66ccff">
                    <?= Html::tag('h4',Html::encode('Investitor') . Html::img('@web/frontend/web/img/investor.png',['alt'=>'Investor logo','style'=>'width:25px']),['class'=>"card-title text-bold"])?>
                </div>
                <div class="panel-body text-center">
                    <p class="text-justify">
                        Investitorul este  cel care crede in reteaua noastra. Efectueaza tranzactii, si utilizeaza protocoalele retelei. Contribuie la viitorul unei economii
                        in care puterea este detinuta de utilizator. Reprezinti subiectul principal in aceasta lume, un pionier al tehnologiei.
                    </p>
                    <br>
                    <?= Html::a('Alege sa devii investitor', Url::to(['/site/confirmare-investitor','username'=>$username]),['id'=>"investor" , 'class'=>'btn btn-info']) ?>
                </div>
            </div>   
           </div>  
    </div>    
</div>

<?php $this->registerCssFile('@web/frontend/web/css/confirm-role.css',['depends' => [\yii\bootstrap\BootstrapAsset::class]])?>