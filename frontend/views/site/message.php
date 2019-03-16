<?php
use yii\helpers\Html;



$this->title = Yii::t('user', 'Bun venit in Pandora');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container">
    <div class="row">
        <div id = "card" class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="card card-signup">    
                <div class="panel-body text-justify">
                    <?= $message?>
                </div>
                <div class="text-center">
                    <?= Html::a("<i class='material-icons'>keyboard_return</i> " .'Intoarce-te la pagina de logare', ['index'],['id'=>"miner" , 'class'=>'btn btn-link btn-sm btn-round']) ?>
                </div>
            </div>
        </div>
    </div>
</div>        

<?php $this->registerCss('
body{
    background: linear-gradient(60deg,#FDC830,#F37335);
}
#card{
    padding-top: 10em;
}
.btn{
    background-color: transparent;

}
')?>