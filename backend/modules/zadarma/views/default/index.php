<?php
/**
 * @author Alex Novak <alexleonnovak@gmail.com>
 */ 

use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use backend\modules\zadarma\ZadarmaAsset;

/* @var $balance backend\modules\zadarma\components\Zadarma */
/* @var $this yii\web\View */

ZadarmaAsset::register($this);

?>


<div class="zadarma-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>

    <div>Баланс: <?=$balance->balance . ' ' . $balance->currency ?></div>
        <?php 


        echo '<br>';
        print_r($call); 
        ?>
    <?php Pjax::begin(); ?>
        <?php $form = ActiveForm::begin(); ?>
        <?= Html::input('text', 'from'); ?>
        <?= Html::input('text', 'to'); ?>
        <?= Html::submitButton('Позвонить',['class' => 'btn btn-success']); ?>
    
        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    

</div>
<div class="container">
	<h3 class="web-phone-header">
    	Звонки с сайта
		<input type="button" id="notifications_btn" class="btn btn-active-notifications" value="Уведомления включены">
	</h3>
   
	<div class="row webrtc-row">

		<div class="col-md-4">
            
			
			<div class="phone-view active">

				<div class="number-field">
                    <a class="backspace">
                        <img src="/images/webrtc/backspace.svg">
                    </a>

                    <input type="tel" id="phoneNumber" class="phoneNumber" value="">
                    <!-- value="+447970910586"-->
                    
                    <span class="duration-time" id="duration"></span>

                    <div class="bottom-phone-number">
                        <div class="enter-phone-block">
                            Введите номер телефона
                        </div>
                        <div class="detected-block">
                            <i class="flag no-flag flag-ua"></i>
                            <span class="min-price">Ukraine Lifecell - mobile - 0.19 €</span>/мин
                        </div>
                    </div>
                    

                    <div class="call-meta clearfix">
                        <span class="pull-left">
                            <span class="status">Звоним</span>

                            <span class="small" id="toNum">1111</span>

                        </span>
                    </div>

				</div>
				<!-- /.number-field -->
				<div class="keyboard">

					<div class="keyboard__numpad">
						<div class="error-message">Звонок завершен<br><span class="small">00:00:05</span></div>
                        
                        <div class="error-close" style="display: none;">
							<a href="javascript:void(0);" onclick="hideErrorMessage(true,true);"><i class="glyphicon glyphicon-remove"></i></a>
						</div>

						<div class="incoming-info">
							<span class="small">Входящий звонок от</span>
							<br>
							<span id="fromNum"><!--+447970910586--></span>
						</div>

						<div class="slider-column left">

							<a class="slider-icon top" id="speakerOn">
								<img src="/images/webrtc/volumeon@2x.svg">
							</a>

							<a class="slider-icon bottom active" id="speakerOff">
								<img src="/images/webrtc/volumeoff@2x.svg">
							</a>

							<div class="slider slider-vertical" id=""><div class="slider-track"><div class="slider-track-low" style="top: 0px; height: 0%;"></div><div class="slider-selection" style="top: 0%; height: 100%;"></div><div class="slider-track-high" style="bottom: 0px; height: 0%;"></div></div><div class="tooltip tooltip-main right hide" role="presentation" style="left: 100%; top: 0%; margin-top: 0px;"><div class="tooltip-arrow"></div><div class="tooltip-inner">1</div></div><div class="tooltip tooltip-min right hide" role="presentation" style="left: 100%;"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div><div class="tooltip tooltip-max right hide" role="presentation" style="left: 100%;"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div><div class="slider-handle min-slider-handle round" role="slider" aria-valuemin="0" aria-valuemax="1" aria-valuenow="1" tabindex="0" style="top: 0%;"></div><div class="slider-handle max-slider-handle round hide" role="slider" aria-valuemin="0" aria-valuemax="1" aria-valuenow="1" tabindex="0" style="top: 100%;"></div></div><input id="speaker-slider" type="text" data-slider-step="1" data-slider-orientation="vertical" data-slider-selection="after" data-slider-tooltip="hide" style="display: none;" data-value="1" value="1">
						</div>
						<div class="num-pad clearfix">

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										1
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										2
									</div>

									<div class="small">
										ABC
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										3
									</div>

									<div class="small">
										DEF
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										4
									</div>

									<div class="small">
										GHI
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										5
									</div>

									<div class="small">
										JKL
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										6
									</div>

									<div class="small">
										MNO
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										7
									</div>

									<div class="small">
										PQRS
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										8
									</div>

									<div class="small">
										TUV
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										9
									</div>

									<div class="small">
										WXYZ
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										*
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										0
									</div>

									<div class="small">
										+
									</div>

								</div>

							</div>

							<div class="span3 digitForm num">

								<div class="txt">

									<div class="digit">
										#
									</div>

								</div>

							</div>

							<div class="actions">

								<div class="span3">
									<a href="#" class="round-button small" id="newContactNum">
										<span class="icon add-user"></span>
									</a>
								</div>

								<div class="span3">

									<a href="#" class="round-button call" style="animation: none;">
										<span class="glyphicon glyphicon-remove"></span>
										<span class="icon phone">
											<svg xmlns="http://www.w3.org/2000/svg" width="39" height="14" viewBox="0 0 39 14" fill="currentColor">
												<path d="M32.7548941,37.978813 C27.3575607,37.809553 21.0629725,32.659213 16.7222666,28.368813 C12.3809333,24.078413 7.1699529,17.857333 7.00054114,12.584233 C6.94281565,10.800493 11.5225804,7.49217301 11.5690117,7.45993301 C12.5898745,6.75685301 13.9621098,6.89015301 14.5205411,7.65337301 C14.8863451,8.15371301 18.3862666,13.397053 18.7690117,13.994113 C19.1473647,14.582493 19.0877568,15.467853 18.6096392,16.363133 C18.3329333,16.883933 17.3955215,18.511433 16.9876784,19.218233 C17.4193647,19.835753 18.6297176,21.428533 21.1878353,23.956273 C23.7610117,26.498273 25.3610117,27.684953 25.9821882,28.109033 C26.6981098,27.705413 28.345796,26.778513 28.8741098,26.503853 C29.7500313,26.046913 30.6617176,25.980573 31.2603058,26.341413 C31.8890117,26.721473 37.1828156,30.199673 37.677247,30.540673 C38.0656392,30.809753 38.3166196,31.273513 38.3649333,31.814773 C38.4145019,32.367193 38.2425804,32.952473 37.8805411,33.463353 C37.8472862,33.507993 34.5406196,37.978813 32.7548941,37.978813 Z" transform="rotate(135 24.086 14.868)"></path>
											</svg>
									</span>
									</a>

									<a href="#" class="round-button accept-call">
									<span class="icon phone">
										<svg xmlns="http://www.w3.org/2000/svg" width="39" height="14" viewBox="0 0 39 14" fill="currentColor">
											<path d="M32.7548941,37.978813 C27.3575607,37.809553 21.0629725,32.659213 16.7222666,28.368813 C12.3809333,24.078413 7.1699529,17.857333 7.00054114,12.584233 C6.94281565,10.800493 11.5225804,7.49217301 11.5690117,7.45993301 C12.5898745,6.75685301 13.9621098,6.89015301 14.5205411,7.65337301 C14.8863451,8.15371301 18.3862666,13.397053 18.7690117,13.994113 C19.1473647,14.582493 19.0877568,15.467853 18.6096392,16.363133 C18.3329333,16.883933 17.3955215,18.511433 16.9876784,19.218233 C17.4193647,19.835753 18.6297176,21.428533 21.1878353,23.956273 C23.7610117,26.498273 25.3610117,27.684953 25.9821882,28.109033 C26.6981098,27.705413 28.345796,26.778513 28.8741098,26.503853 C29.7500313,26.046913 30.6617176,25.980573 31.2603058,26.341413 C31.8890117,26.721473 37.1828156,30.199673 37.677247,30.540673 C38.0656392,30.809753 38.3166196,31.273513 38.3649333,31.814773 C38.4145019,32.367193 38.2425804,32.952473 37.8805411,33.463353 C37.8472862,33.507993 34.5406196,37.978813 32.7548941,37.978813 Z" transform="rotate(135 24.086 14.868)"></path>
										</svg>
									</span>
									</a>

								</div>
								<div class="span3">
									<a href="#" class="round-button small">
										<span class="icon message"></span>
									</a>
								</div>
							</div>

						</div>

						<div class="slider-column right">
							<a class="slider-icon top" id="micOn">
								<img src="/images/webrtc/micon@2x.svg">
							</a>
							<a class="slider-icon bottom" id="micOff">
								<img src="/images/webrtc/micoff@2x.svg">
							</a>
							<div class="slider slider-vertical" id=""><div class="slider-track"><div class="slider-track-low" style="top: 0px; height: 50%;"></div><div class="slider-selection" style="top: 50%; height: 50%;"></div><div class="slider-track-high" style="bottom: 0px; height: 0%;"></div></div><div class="tooltip tooltip-main right hide" role="presentation" style="left: 100%; top: 50%; margin-top: 0px;"><div class="tooltip-arrow"></div><div class="tooltip-inner">0.5</div></div><div class="tooltip tooltip-min right hide" role="presentation" style="left: 100%;"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div><div class="tooltip tooltip-max right hide" role="presentation" style="left: 100%;"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div><div class="slider-handle min-slider-handle round" role="slider" aria-valuemin="0" aria-valuemax="1" aria-valuenow="0.5" tabindex="0" style="top: 50%;"></div><div class="slider-handle max-slider-handle round hide" role="slider" aria-valuemin="0" aria-valuemax="1" aria-valuenow="1" tabindex="0" style="top: 100%;"></div></div><input id="mic-slider" type="text" data-slider-step="1" data-slider-orientation="vertical" data-slider-selection="after" data-slider-tooltip="hide" style="display: none;" data-value="0.5" value="0.5">
						</div>
					</div>

					<div class="sip-selector" style="z-index: 1;">
						<div class="selectric-wrapper selectric-form-control selectric-below"><div class="selectric-hide-select"><select id="username" name="username" class="form-control" onchange="getRegParams(this.value);" tabindex="-1">
							<option value="976463" selected="selected">SIP (976463)</option>						</select></div><div class="selectric"><span class="label">SIP (976463)</span><b class="button">▾</b></div><div class="selectric-items" tabindex="-1" style="width: 200px;"><div class="selectric-scroll"><ul><li data-index="0" class="last selected highlighted">SIP (976463)</li></ul></div></div><input class="selectric-input" tabindex="0"></div>
					</div>
					<!-- /.sip-selector -->
				</div>
				<!-- /.keyboard -->
			</div>

		</div>

		<div class="col-md-8">

			<div class="panel webrtc">

				<!-- Nav tabs -->
				<ul class="nav nav-pills" role="tablist">
					<!--<li role="presentation"
					    class="active">
						<a href="#keypad"
						   aria-controls="home"
						   role="tab"
						   data-toggle="tab"><img src="/images/webrtc/keypadTab@2x.svg"></a>
					</li>-->
					<li role="presentation" class="active has-popover" data-toggle="popover" data-placement="top" title="" data-content="Журнал звонков" data-original-title="" data-html="true">
						<a href="#recent" aria-controls="recent" role="tab" data-toggle="tab">
							<img src="/images/webrtc/recentTab@2x.svg">
						</a>
					</li>
					<!--<li role="presentation">
						<a href="#messages"
							 aria-controls="messages"
							 role="tab"
							 data-toggle="tab">
							<img src="/images/webrtc/messagesTab@2x.svg">
						</a>
					</li>-->
					<li role="presentation" class="has-popover" data-toggle="popover" data-placement="top" title="" data-content="Список контактов" data-original-title="" data-html="true">
						<a href="#contacts" aria-controls="contacts" role="tab" data-toggle="tab">
							<img src="/images/webrtc/contactsTab@2x.svg">
						</a>
					</li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
					<!-- incoming -->
					<!--<div role="tabpanel"
					     class="tab-pane active"
					     id="keypad">

					</div>-->
					<!-- /.tab-pane -->

					<div role="tabpanel" class="tab-pane active" id="recent">

						<ul class="recent-list">
					<li class="recent-list__item" data-number="1111">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="1111">
								1111
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 16:33
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="1111">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="1111">
								1111
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 16:24
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="1111">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="1111">
								1111
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								6m 39s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 16:16
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="1111">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="1111">
								1111
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 16:11
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="1111">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="1111">
								1111
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 16:08
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="1111">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="1111">
								1111
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 15:12
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="+380936066093">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="+380936066093">
								+380936066093
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 15:11
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="+380936066093">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="+380936066093">
								+380936066093
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 10s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 15:10
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="1111">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="1111">
								1111
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								2h 22m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 12:45
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="1111">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="1111">
								1111
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 5s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 11:57
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="1111">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="1111">
								1111
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 10:29
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="4444">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="4444">
								4444
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 5s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 10:21
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="+380936066093">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="+380936066093">
								+380936066093
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 2s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 10:19
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="+380936066093">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="+380936066093">
								+380936066093
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								27.04.2018 09:08
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="+380936066093">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="+380936066093">
								+380936066093
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								26.04.2018 17:49
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="465465465">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="465465465">
								465465465
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 6s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								26.04.2018 17:44
							</div>
						</div>
		
					</li>
				
					<li class="recent-list__item" data-number="465465465">
		
						<div class="recent-list__item__main">
							<img class="recent-list__item__image" src="/images/webrtc/defaultUserpic@2x.svg" alt="profile">
										
							<div class="recent-list__item__name" title="465465465">
								465465465
							</div></div>
		
						<div class="recent-list__item__details">
							<div class="recent-list__item__cash-time">
								0m 7s
							</div>
		
							<div class="recent-list__item__date call-icon call-icon--out-call">
								26.04.2018 17:44
							</div>
						</div>
		
					</li>
				</ul>

					</div>
					<!-- /.tab-pane -->

					<!--<div role="tabpanel"
							 class="tab-pane"
							 id="messages">...
					</div>-->
					<!-- /.tab-pane -->

					<div role="tabpanel" class="tab-pane" id="contacts">

						<div class="contact-book">

							<input type="text" id="contacts-search-input" class="contacts-search-input" placeholder="Search contacts">

							<div class="contacts">

								<ul class="contacts-list"></ul>

								<div class="btn add-user-btn">
									<i class="fa fa-user-plus"></i>
								</div>

							</div>
							<!-- /.contacts -->
							<div class="new-contact-form">

								<div class="contact-info">

									<div class="contact-info__name" data-name="Новый контакт">
										<!--Rachel Fowler-->
									</div>

									<div class="contact-info__actions">

										<div class="contact-info__call">
											<img src="/images/webrtc/contact-phone.svg" alt="call">
										</div>

									</div>

								</div>
								<!-- /.contact-info -->
								<form action="" data-action="" class="contact-form">
									<input id="contactId" name="contactId" type="hidden" value="">
									<div class="label-input">
										<label class="contact-label" for="contact-full-name">Имя</label>
										<input type="text" class="contact-input" id="contact-full-name" name="contact-full-name">
									</div>
									
                                    <div class="label-input">
										<label class="contact-label">Телефон</label>
										<div class="phones-inputs"></div>
									</div>
                                    
                                    <div class="label-input">
										<label class="contact-label" for="contact-sip">Zadarma SIP</label>
										<input type="number" class="contact-input contact-input--small" id="contact-sip" name="contact-sip">
									</div>
                                    
									<div class="label-input">
										<label class="contact-label" for="contact-email">Электронный адрес</label>
										<input type="email" class="contact-input" id="contact-email" name="contact-email">
									</div>

									<div class="label-input">
										<label class="contact-label" for="contact-comment">Комментарий</label>
										<input type="text" class="contact-input" id="contact-comment" name="contact-comment">
									</div>

									<div id="contact_result" class="text-warning" style="display:none;"></div>
									
                                    <div style="clear:both; width:100%;">
                                        <button type="reset" class="contact-button contact-button--close">
                                        </button>
                                        
                                        <button type="submit" class="contact-button">Сохранить
                                        </button>
    
                                        <div class="btn btn-delete" data-text="Are you sure to delete">Удалить контакт</div>
									</div>
								</form>

								

							</div>
							<!-- /.new-contact-form -->
                                                        <div class="phones-call">
								<ul class="phones-list"></ul>
							</div>
							<!-- /.phone-call -->
						</div>
						<!-- /.contact-book -->
					</div>
					<!-- /.tab-pane -->

				</div>
			</div>

		</div>

	</div>
</div>

<video id="webRTCSelfView" autoplay="" muted="true" _hidden="true" style="display: none"></video>
<video id="webRTCRemoteView" autoplay=""></video>

<!--<audio id="incomingRing"-->
<!--src="out.wav"-->
<!--loop>-->
<!--</audio>-->

<!--<audio id="outgoingRing"-->
<!--src="out.wav"-->
<!--loop>-->
<!--</audio>-->

<audio id="incomingRing" src="/assets/in.wav" preload="auto"></audio>

<audio id="outgoingRing" src="/assets/out.wav" preload="auto"></audio>

<!-- УЖЕ ДОБАВЛЕНО -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/bootstrap-slider.min.js"></script>
<!-- УЖЕ ДОБАВЛЕНО -->

<!-- ДОБАВИТЬ В САМЫЙ НИЗ ДОКУМЕНТА ПЕРЕД </BODY> -->
<script src="/js/mediastream-gain-controller.js?ver=1521462845"></script>
<script src="/js/jssip.min.js?ver=1521462845"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.4/lodash.min.js"></script>
<script src="/js/jquery.selectric.min.js?ver=1521462845"></script>
<script src="/js/detectWebRTC.min.js?ver=1521462845"></script>
<script src="/js/contact-book.js?ver=1521462845"></script>
<script src="/js/phone.js?ver=1523444533"></script>

<script src="/js/phoneView.js?ver=1523444533"></script>
<!--<script>JsSIP.debug.enable('JsSIP:*');</script>-->

<script src="https://www.gstatic.com/firebasejs/4.6.0/firebase.js"></script>
<script>
$(document).ready(function () {
	$(".has-popover").popover({ trigger: "hover" });
	
	$('#notifications_btn').click(function(){
		requestPermit();
	});

	if (!DetectRTC.isWebRTCSupported) {
		$('.phone-not-available').addClass('active');
		$('.phone-view').remove();
	} else if(AudioContext === false){
		$('.phone-not-available').addClass('active');
		$('.phone-view').remove();
	} else {
		$('.phone-view').addClass('active');
		$('.phone-not-available').remove();
	}
	
	setStartUsername();
	$('#phoneNumber').val('');
});
</script>
<!-- ДОБАВИТЬ В САМЫЙ НИЗ ДОКУМЕНТА ПЕРЕД </BODY> -->    </div>
</div>
</div>
