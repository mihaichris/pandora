<?php

use yii\helpers\Html;
use kartik\number\NumberControl;


?>

<!-- Modal pentru confirmare tranzactie-->
<div class="modal fade" id="confirm-transaction-modal" tabindex="-1" role="dialog" aria-labelledby="confirmTransaction" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
			<div class="card card-signup card-plain">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
					<h2 class="modal-title card-title text-center" id="confirmTransaction">Confirmare Ordin</h2>
		      	</div>
		      	<div class="modal-body">
					<div class="row">
						<div class="col-md-5 col-md-offset-1">
							<div class="info info-horizontal">
								<div class="icon icon-rose">
									<i class="material-icons text-rose">timeline</i>
								</div>
								<div class="description">
									<h4 class="info-title">Evoluție</h4>
									<p class="description text-justify">
										Deșcentralizarea poate contribui la dezvoltarea elementelor cheie a unei buni evoluții economice, fără limite impuse de instituțiile actuale care controlează fluxul tranzacțiilor.
									</p>
								</div>
							</div>
							<div class="info info-horizontal">
								<div class="icon icon-info">
									<i class="material-icons text-warning">group</i>
								</div>
								<div class="description">
									<h4 class="info-title">Încredere</h4>
									<p class="description text-justify">
										Rețeaua Pandora se bazează nu doar pe încrederea participanțiilor la retea ci și pe tehnologia în care crede fiecare participant.
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<?= Html::beginTag('div',['class'=>"form-group"]);?>
								<?= Html::label('Numele destinatarului',['class'=>'form-label'])?>
								<div class='input-group'>
									<span class='input-group-addon'>
										<i class='material-icons'>face</i>
									</span>
									<?= Html::input('text','receiver_name','',['class'=>'form-control','id'=>'receiver_name','readonly '=>true])?>
								</div>
							<?= Html::endTag('div');?>
							<?= Html::beginTag('div',['class'=>"form-group"]);?>
								<?= Html::label('Suma tranzacției','value',['class'=>'form-label'])?>
								<div class='input-group'>
									<span class='input-group-addon'>
										<i class='material-icons'>attach_money</i>
									</span>
									<?= NumberControl::widget([
									'id'=>'value',
									'name' => 'value',
									'value' => null,
									'displayOptions' => [
										'class'=>'form-control',
										'readonly '=>true,
									],
									'maskedInputOptions' => [
										'prefix' => '€ ',
										'groupSeparator' => '.',
										'radixPoint' => ',',
										'allowZero' => true,
										'allowEmpty' => false,
										'allowMinus' => false,
										
									],
								]);?>
								</div>
							<?= Html::endTag('div');?>
							<?= Html::beginTag('div',['class'=>"form-group"]);?>
								<?= Html::label('Semnătura tranzacției','signature',['class'=>'form-label'])?>
								<div class='input-group'>
									<span class='input-group-addon'>
										<i class='material-icons'>border_color</i>
									</span>
									<?= Html::input('text','signature','',['class'=>'form-control','id'=>'signature','readonly '=>true])?>
								</div>
							<?= Html::endTag('div');?>
							<div class="modal-footer">
								<?= Html::a('Confirmă',['/transaction/confirm-transaction'],['data-dismiss'=>'modal','class'=>"btn btn-info  btn-simple","id"=>"confirm-transaction-button"])?>
								<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Anulează</button>
							</div>
						</div>	
					</div>
					</div>
		      	</div>
			</div>
	    </div>
	</div>
</div>
<!-- Modal pentru confirmare tranzactie-->

<!-- Modal pentru adaugare bani in cont-->
<div class="modal fade" id="add-money" tabindex="-1" role="dialog" aria-labelledby="addMoney" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="material-icons">clear</i>
				</button>
				<h4 class="modal-title">Adaugă un nou deposit la contul tău !</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-5 col-md-offset-1">
						<div class="info info-horizontal">
							<div class="icon icon-rose">
								<i class="material-icons text-info">security</i>
							</div>
							<div class="description">
								<h4 class="info-title ">Securitate</h4>
								<p class="description text-justify">
									Informațiile sunt stocate și criptate în baza de date. Acest lucru este necesar pentru a oferi o experiență cât mai usoară si fluidă pentru utilizator.
								</p>
							</div>
						</div>

						<div class="info info-horizontal">
							<div class="icon icon-primary">
								<i class="material-icons text-primary">lock</i>
							</div>
							<div class="description">
								<h4 class="info-title ">Confidențialitate</h4>
								<p class="description text-justify">
									Valoarea depozitată va rămâne întotdeauna accesibilă doar deținătorului acestui portofel, informațiile stocate vor fi utilizate doar in scop intern.
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<?= Html::beginTag('div',['class'=>"form-group"]);?>
						<?= Html::label('Valoarea depozitată','deposit',['class'=>'form-label'])?>
                            <?= NumberControl::widget([
								'id'=>'deposit',
                                'name' => 'deposit',
								'value' => null,
                                'displayOptions' => [
                                    'placeholder' => 'Introdu o sumă validă...',
                                    'class'=>'form-control',
                                ],
                                'maskedInputOptions' => [
                                    'prefix' => '€ ',
                                    'groupSeparator' => '.',
                                    'radixPoint' => ',',
                                    'allowZero' => false,
                                    'allowEmpty' => true,
                                    'allowMinus' => false
                                ],
                            ]);?>
                        <?= Html::endTag('div');?>
					</div>
				</div>	
			</div>
			<div class="modal-footer">
				<?= Html::a('Adaugă depozit',['/wallet/add-balance'],['data-dismiss'=>'modal','class'=>"btn btn-warning  btn-simple","id"=>"add-balance-button"])?>
				<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Anulează</button>
			</div>
		</div>
	</div>
</div>

<!--  Modal pentru adaugare bani in cont-->

