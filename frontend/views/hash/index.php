<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title = 'Hashing';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="card card-pricing card-raised rounded">
                    <div class="card-content">
                        <h6 class="category">Algoritmul de hashing <i class="material-icons text-rose">message</i></h6>
                        <?= Html::input('text','message','', [
                                        'class'=>'form-control',
                                        'placeholder'=>"Informatie necriptata",
                                        "id"=>"message-input"]) ?>
                        <p class="card-description">
                            Introdu un mesaj si observa cum se cripteaza acesta. Acelasi algoritm este utilizat si pentru criptarea blocurilor din retea.
                        </p>
                    </div>
                </div>
            </div>    
            <div class="row">
                <div class="card card-nav-tabs rounded">
                <div class="card-header" data-background-color="purple">
                    <i class="material-icons">whatshot</i>
                    <span class="pull-right" data-toggle="tooltip" data-placement="top" title="Hashing-ul mesajului va fi intotdeauna acelasi ! Astfel daca exista o corupere de informatie , acest lucru se va afla.">
                        <a href="#">
                            <i class="material-icons">info</i>
                        <div class="ripple-container"></div></a>
                    </span>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    <h4 class="card-title text-center">Hash-ul informatiei <i class="material-icons text-info">lock</i></h6></h4>
                    <?= Html::input('text','hash_message','', [
                                        'class'=>'form-control text-center',
                                        'readonly'=> true,
                                        "id"=>"hash_message-input",
                                        'placeholder'=>"Informatie criptata"]) ?>
                        <p class="card-description">
                    </div>
                </div>
                </div>
            </div> 
        </div>
        <div class="col-md-4">
            <div class="card card-raised rounded">   
                 <div class="card-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="info text-center">
                                <div class="icon">
                                    <i class="material-icons text-primary" style="font-size:3em">chat</i>
                                </div>
                                <h4 class="info-title">Free Chat</h4>
                                <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p>
                            </div> 
                        </div> 
                    </div>
                    <div class="row">       
                        <div class="col-md-12">
                            <div class="info info-horizontal text-center">
                                <div class="icon icon-rose">
                                    <i class="material-icons text-rose" style="font-size:3em">group_work</i>
                                </div>
                                <div class="description">
                                    <h4 class="info-title">Collaborate</h4>
                                    <p>The moment you use Material Kit, you know you’ve never felt anything like it. With a single use, this powerfull UI Kit lets you do more than ever before. </p>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row">       
                        <div class="col-md-12">
                            <div class="info info-horizontal text-center">
                                <div class="icon icon-rose">
                                    <i class="material-icons text-success" style="font-size:3em">code</i>
                                </div>
                                <div class="description">
                                    <h4 class="info-title">Collaborate</h4>
                                    <p>The moment you use Material Kit, you know you’ve never felt anything like it. With a single use, this powerfull UI Kit lets you do more than ever before. </p>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row">       
                        <div class="col-md-12">
                            <div class="info info-horizontal text-center">
                                <div class="icon icon-rose">
                                    <i class="material-icons text-info" style="font-size:3em">graphic_eq</i>
                                </div>
                                <div class="description">
                                    <h4 class="info-title">Collaborate</h4>
                                    <p >The moment you use Material Kit, you know you’ve never felt anything like it. With a single use, this powerfull UI Kit lets you do more than ever before. </p>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>    
            </div>
        </div>
    </div>    
    <div class="row">  
        <div class="col-md-6">
        </div>
    </div>
</div>


<?php $this->registerJsFile(
    '@web/frontend/web/js/hashing.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);?>