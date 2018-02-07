<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\Spinner;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use yii\web\View;
use kartik\widgets\Alert;
use frontend\backend\sistem\models\Store;

$this->title = 'User Profiles';
$headerColor='rgba(128, 179, 178, 1)';
//print_r($userProvinsi);
$this->registerCss("
	:link {
		color: #fdfdfd;
	}
	/* mouse over link */
	a:hover {
		color: #5a96e7;
	}
	/* selected link */
	a:active {
		color: blue;
	}
	.modal-content { 
		border-radius: 50;
	},
	.kv-panel {
		//min-height: 340px;
		height: 300px;
	}
	#gv-store .kv-grid-container{
		height:200px
	}
	#gv-store .panel-heading {
		background: linear-gradient( 135deg, #2AFADF 10%, #4C83FF 100%);
		color:#000;
	}
	#gv-store .panel-footer {
		background: linear-gradient( 135deg, #2AFADF 10%, #4C83FF 100%);
	}
	#dv-info .panel-heading {
		background: linear-gradient( 135deg, #2AFADF 10%, #4C83FF 100%);
		color:#000;
	}
	#dv-info .panel-footer {
		background: linear-gradient( 135deg, #2AFADF 10%, #4C83FF 100%);
	}
");
$this->registerJs($this->render('modal_store.js'),View::POS_READY);
echo $this->render('button_store'); //echo difinition
echo $this->render('modal_store'); //echo difinition
		
	//Difinition Status.
	$aryStt= [
	  ['STATUS' => 0, 'STT_NM' => 'Trial'],		  
	  ['STATUS' => 1, 'STT_NM' => 'Active'],
	  ['STATUS' => 2, 'STT_NM' => 'Deactive'],
	  ['STATUS' => 3, 'STT_NM' => 'Deleted'],
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
	$user = (empty(Yii::$app->user->identity->ACCESS_GROUP)) ? '' : Yii::$app->user->identity->ACCESS_GROUP;
    
	function sttMsgDscp($stt){
		if($stt==0){ //TRIAL
			 return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-check fa-stack-1x" style="color:#ee0b0b"></i>
					</span>','',['title'=>'Trial']);
		}elseif($stt==1){
			 return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-check fa-stack-1x" style="color:#05944d"></i>
					</span>','',['title'=>'Active']);
		}elseif($stt==2){
			return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-remove fa-stack-1x" style="color:#01190d"></i>
					</span>','',['title'=>'Deactive']);
		}elseif($stt==3){
			return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-close fa-stack-1x" style="color:#ee0b0b"></i>
					</span>','',['title'=>'Delete']);
				}
	};	
		
	$dscLabel='<b>* STATUS</b> : '.sttMsgDscp(0).'=Trial. '.sttMsgDscp(1).'=Active. '.sttMsgDscp(2).'=Deactive. '.sttMsgDscp(3).'=Delete. ';
	
	
	//Result Status value.
	function sttMsg($stt){
		if($stt==0){ //TRIAL
			 return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-check fa-stack-1x" style="color:#ee0b0b"></i>
					</span>','',['title'=>'Trial']);
		}elseif($stt==1){
			 return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-check fa-stack-1x" style="color:#05944d"></i>
					</span>','',['title'=>'Active']);
		}elseif($stt==2){
			return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-remove fa-stack-1x" style="color:#01190d"></i>
					</span>','',['title'=>'Deactive']);
		}elseif($stt==3){
			return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-close fa-stack-1x" style="color:#ee0b0b"></i>
					</span>','',['title'=>'Delete']);
		}
	};	
	
	
	
	
	$bColor='rgba(87,114,111, 1)';
		
	$gvAttributeItem=[
			[
				'attribute'=>'STORE_NM',
				'label'=>'NAMA TOKO',
				'filterType'=>true,
				'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','250px'),
				'hAlign'=>'right',
				'vAlign'=>'middle',
				'mergeHeader'=>false,
				'format'=>'html',
				'noWrap'=>false,
				'format'=>'raw',
				'filter' => ArrayHelper::map(Store::find()->where(['ACCESS_GROUP'=>$user])->orderBy(['STATUS'=>SORT_ASC])->all(),'STORE_NM','STORE_NM'),
				'filterType'=>GridView::FILTER_SELECT2,
				'filterWidgetOptions'=>[
					'pluginOptions' =>Yii::$app->gv->gvPliginSelect2(),
				],
				'filterInputOptions'=>['placeholder'=>'Cari STORE'],
				'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
				'headerOptions'=>Yii::$app->gv->gvContainHeader('center','250px',$headerColor),
				'contentOptions'=>Yii::$app->gv->gvContainBody('left','250px',''),
				
			],		
		
		//PROVINCE
		[
			'attribute'=>'PROVINCE_NM',
			'label'=>'PROVINSI',
			// 'filter' => $aryProvinsi,
			'filter' => ArrayHelper::map(Store::find()->where(['ACCESS_GROUP'=>$user])->orderBy(['STATUS'=>SORT_ASC])->all(),'PROVINCE_NM','PROVINCE_NM'),
			'filterType'=>GridView::FILTER_SELECT2,
			'filterWidgetOptions'=>[
				'id'=>'access',
				'pluginOptions' =>Yii::$app->gv->gvPliginSelect2(),
			],
			'filterInputOptions'=>['placeholder'=>'Cari Provinsi','id'=>'provinsi'],
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			'format'=>'raw',
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$headerColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],		
		//CITY
		[
			'attribute'=>'CITY_NAME',
			'label'=>'KOTA',
			'filterType'=>GridView::FILTER_SELECT2,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginSelect2(),
			],
			'filterInputOptions'=>['placeholder'=>'Cari Kota','id'=>'kota'],	
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),						
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			'format'=>'raw',
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$headerColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],	
		
	];
	$gvAttributeItem[]=[
		'attribute'=>'STATUS',
		'filterType'=>GridView::FILTER_SELECT2,
		'filterWidgetOptions'=>[
			'pluginOptions' =>Yii::$app->gv->gvPliginSelect2(),
		],
		'filterInputOptions'=>['placeholder'=>'Select'],
		'filter'=>$valStt,//Yii::$app->gv->gvStatusArray(),
		'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px',$headerColor),
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'mergeHeader'=>false,
		'noWrap'=>false,
		'format' => 'raw',	
		'value'=>function($model){
			return sttMsg($model->STATUS);				 
		},
		'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50',$headerColor),
		'contentOptions'=>Yii::$app->gv->gvContainBody('center','50','')			
	];
	
	
	$gvAttributeItem[]=[
		'class' => 'kartik\grid\ActionColumn',
		'template' => '{review}{payment}{edit}{delete}',
		'header'=>'ACTION',
		'dropdown' => true,
		'dropdownOptions'=>[
			'class'=>'pull-right dropdown',
			'style'=>'width:100%;background-color:#E6E6FA'				
		],
		'dropdownButton'=>[
			'label'=>'ACTION',
			'class'=>'btn btn-info btn-xs',
			'style'=>'width:100%'		
		],
		'buttons' => [
			'edit' =>function ($url, $model){
				if($model->STATUS!=3){
					return  tombolUpdate($url, $model);
				}	
			},
			'delete' =>function ($url, $model){
				if($model->STATUS!=3 && $model->owner=="OWNER"){
					return  tombolDelete($url, $model);
				}	
			},
			'review' =>function($url, $model,$key){
				if($model->STATUS!=1){ //Jika sudah close tidak bisa di edit.
					return  tombolReview($url, $model);
				}					
			},
			'payment' =>function($url, $model,$key){
				if($model->STATUS!=1 && $model->DATE_END>=date('Y-m-d')){ //Jika sudah close tidak bisa di edit.
					return  tombolPayment($model);
				}					
			}
		], 
		'headerOptions'=>Yii::$app->gv->gvContainHeader('center','10px',$headerColor,'#ffffff'),
		'contentOptions'=>Yii::$app->gv->gvContainBody('center','0',''),
	]; 
	$gvStore=GridView::widget([
		'id'=>'gv-store',
		'dataProvider' => $dataProviderstore,
		'filterModel' => $searchModelstore,
		'columns'=>$gvAttributeItem,		 
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-store',
		    ],						  
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		'export' => false,
		'panel'=>[''],
		'toolbar' => [
			''
		],
		'panel' => [
			//'heading'=>false,
			'heading'=>'
				<span class="fa-stack fa-sm">
				  <i class="fa fa-circle-thin fa-stack-2x" style="color:#25ca4f"></i>
				  <i class="fa fa-text-width fa-stack-1x"></i>
				</span> LIST TOKO'.'  <div style="float:right"><div style="font-family: tahoma ;font-size: 8pt;"> </div></div> ',  
			'type'=>'info',
			'before'=>false,
			'after'=>false,
			'before'=>$dscLabel.'<div class="pull-right">'. tombolRefresh().' '.tombolExportExcel().' '.tombolReqStore().' '.tombolRestore().'</div>',
			// 'before'=> tombolReqStore(),
			'showFooter'=>'aas',
		], 
		// 'floatOverflowContainer'=>true,
		//'floatHeader'=>true,
	]); 
	
?>

<div class="container-fluid">
    <div class="user-profile-index">	
	<?php if (Yii::$app->session->hasFlash('success')){ ?>
			<?php
				echo Alert::widget([
					'type' => Alert::TYPE_SUCCESS,
					'title' => 'Well done!',
					'icon' => 'glyphicon glyphicon-ok-sign',
					'body' => Yii::$app->session->getFlash('success'),
					'showSeparator' => true,
					'delay' => 1000
				]);
			?>
		<?php } elseif (Yii::$app->session->hasFlash('error')) {
			echo Alert::widget([
				'type' => Alert::TYPE_DANGER,
				'title' => 'Oh snap!',
				'icon' => 'glyphicon glyphicon-remove-sign',
				'body' => Yii::$app->session->getFlash('error'),
				'showSeparator' => true,
				'delay' => 1000
			]);
		}?>
<div class="row">
    <div class="col-sm-2">
		<?php if(empty($dataProviderimage->ACCESS_IMAGE)){?>
			<img src="https://www.mautic.org/media/images/default_avatar.png" alt="Your Avatar" class="img-circle" style="width:165px;height:165px;align:center">
		<?php }else{?>
			<img src="<?php echo $dataProviderimage->ACCESS_IMAGE;?>" alt="Your Avatar" class="img-circle" style="width:165px;height:165px;align:center">
		<?php }?>
	</div>
    <div class="col-sm-10">
        <?php echo DetailView::widget([
			'id'=>'dv-info',
            'model'=>$dataProvider,
            'condensed'=>true,
			'hAlign'=>'left',
            'hover'=>true,
            'panel'=>[
                'heading'=>'<b>Detail Profile</b>',
                'type'=>DetailView::TYPE_INFO,
            ],
            'mode'=>DetailView::MODE_VIEW,
            'buttons1'=>'',
            'buttons2'=>'{view}{save}',		
            'attributes' =>[
                [
                    'columns' => [
                        [
							'attribute'=>'nama',
							'label'=>'Nama Lengkap',
                            'enableEditMode'=>false,
                            'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
							'attribute'=>'LAHIR_GENDER',
							'value'=> ($dataProvider->LAHIR_GENDER==1)?"Laki-Laki":
							(($dataProvider->LAHIR_GENDER==2)?"Perempuan":"Harap perbaiki data"),
							'label'=>'Jenis Kelamin',
                            'enableEditMode'=>false,
                            'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
							'attribute'=>'KTP',
							'label'=>'KTP',
                            'enableEditMode'=>false,
                            'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
							'attribute'=>'HP',
							'label'=>'Telepon',
                            'enableEditMode'=>false,
                            'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
                            'attribute'=>'ttl',
							'label'=>'Tempat/Tanggal Lahir',
                            'enableEditMode'=>false,
                            'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:30%']
                        ],
                        [
                            'attribute'=>'EMAIL',
							'label'=>'Email',
                            'enableEditMode'=>false,
                            'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:30%']
                        ],
                    ],
                ],
                [
                    'columns' => [
                        [
							'attribute'=>'ALMAT',
							'label'=>'Alamat',
                            'enableEditMode'=>false,
                            'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:80%']
                        ],
                    ],
                ],
            ]
        ]);?>
		<div class="pull-right">		
			<?php echo tombolEditProfile($dataProvider);?>
			<?php echo tombolChange($dataProvider);?>
		</div>
    </div>
    </div>
	<hr>
	Next For Dompet
	<hr>
        <?php if (Yii::$app->user->identity->ACCESS_LEVEL=="OWNER") {?>
            <?=$gvStore?>
        <?php } ?>
    </div>
</div>