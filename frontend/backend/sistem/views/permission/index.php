<?php
use yii\helpers\Html;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\Pjax;
use yii\web\View;
use kartik\tree\TreeView;
use kartik\tree\TreeViewInput;
use common\models\Locate;
// use common\models\Product;

use frontend\backend\sistem\models\User;
use common\models\UserLogin;
$user = (empty(Yii::$app->user->identity->ACCESS_GROUP)) ? '' : Yii::$app->user->identity->ACCESS_GROUP;
	
$this->title = Yii::t('app', 'User Permission');      /* title pada header page */

$this->params['breadcrumbs'][] = $this->title;
$vewBreadcrumb=Breadcrumbs::widget([
    'homeLink' => [
        'label' => Html::encode(Yii::t('yii', 'Home')),
        'url' => Yii::$app->homeUrl,
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
// $this->registerJs($this->render('modal_store.js'),View::POS_READY);
// echo $this->render('modal_store'); //echo difinition

	$aryStt= [
		  ['STATUS' => 0, 'STT_NM' => 'DISABLE'],		  
		  ['STATUS' => 1, 'STT_NM' => 'ENABLE']
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
	
	$bColor='rgba(52, 235, 138, 1)';
	$gvAttributeItem=[
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','30px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','30px',''),
		],
		//KD_BARCODE
		[
			'attribute'=>'STORE_ID',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','80px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','80px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','80px',''),
			
		],
		//CABANG LOCATE 
		[
			'attribute'=>'PROVINCE_NM',
			//'label'=>'Cutomer',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','150px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','150px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','150px',''),
			
		],		
		//SABANG LOCATE SUB
		[
			'attribute'=>'CITY_NAME',
			//'label'=>'Cutomer',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','100px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','100px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','100px',''),
			
		],		
		//STORE NAME
		[
			'attribute'=>'STORE_NM',
			//'label'=>'Cutomer',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','200px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','200px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','200px',''),
			
		],		
		//STORE PIC.
		[
			'attribute'=>'PIC',
			//'label'=>'Cutomer',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','150px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','150px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','150px',''),
			
		],		
		//STORE TLP.
		[
			'attribute'=>'TLP',
			//'label'=>'Cutomer',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],		
		//STORE ALAMAT
		[
			'attribute'=>'ALAMAT',
			//'label'=>'Cutomer',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','200px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','200px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','200px',''),
			
		],		
		//CREATE_AT
		/* [
			'attribute'=>'CREATE_AT',
			'filterType'=>GridView::FILTER_DATE,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginDate(),
				'layout'=>'{picker}{remove}{input}'
			],
			'filter'=>true,
			'value'=>function($model){
				if ($model->CREATE_AT!=''){
					return $model->CREATE_AT;
				}else{
					return '';
				}
			},
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],
		//CREATE_BY
		[
			'attribute'=>'CREATE_BY',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],	 */	
		//UPDATE_BY
	/* 	[
			'attribute'=>'UPDATE_BY',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		], */
		//'STATUS',
		[
			'attribute'=>'STATUS',
			'filterType'=>GridView::FILTER_SELECT2,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginSelect2(),
			],
			'filterInputOptions'=>['placeholder'=>'Select'],
			'filter'=>$valStt,//Yii::$app->gv->gvStatusArray(),
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>false,
			'noWrap'=>false,
			'format' => 'raw',	
			'value'=>function($model){
				 if ($model->STATUS == 0) {
				  return Html::a('
					<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-close fa-stack-1x" style="color:#0f39ab"></i>
					</span>','',['title'=>'Running']);
				} else if ($model->STATUS == 1) {
				  return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-check fa-stack-1x" style="color:#ee0b0b"></i>
					</span>','',['title'=>'Finish']);
				}
			},
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','50','')			
		],
		//ACTION
		/* [
			'class' => 'kartik\grid\ActionColumn',
			'template' => '{view}{edit}{reminder}{deny}',
			'header'=>'Action',
			'dropdown' => true,
			'dropdownOptions'=>[
				'class'=>'pull-right dropdown',
				'style'=>'width:60px;background-color:#E6E6FA'				
			],
			'dropdownButton'=>[
				'label'=>'Action',
				'class'=>'btn btn-default btn-xs',
				'style'=>'width:100%;'		
			],
			'buttons' => [
				'view' =>function ($url, $model){
				  return  tombolView($url, $model);
				},
				'edit' =>function($url, $model,$key){
					//if($model->STATUS!=1){ //Jika sudah close tidak bisa di edit.
						return  tombolReview($url, $model);
					//}					
				},
				'deny' =>function($url, $model,$key){
					return  tombolDeny($url, $model);
				}

			],
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','10px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','10px',''),
		] */
	];

	// $gvStore=GridView::widget([
	// 	'id'=>'gv-store',
	// 	'dataProvider' => $dataProvider,
	// 	'filterModel' => $searchModel,
	// 	'columns'=>$gvAttributeItem,				
	// 	'pjax'=>true,
	// 	'pjaxSettings'=>[
	// 		'options'=>[
	// 			'enablePushState'=>false,
	// 			'id'=>'gv-store',
	// 	    ],						  
	// 	],
	// 	'hover'=>true, //cursor select
	// 	'responsive'=>true,
	// 	'responsiveWrap'=>true,
	// 	'bordered'=>true,
	// 	'striped'=>true,
	// 	'autoXlFormat'=>true,
	// 	'export' => false,
	// 	'panel'=>[''],
	// 	'toolbar' => [
	// 		''
	// 	],
	// 	'panel' => [
	// 		//'heading'=>false,
	// 		'heading'=>'
	// 			<span class="fa-stack fa-sm">
	// 			  <i class="fa fa-circle-thin fa-stack-2x" style="color:#25ca4f"></i>
	// 			  <i class="fa fa-cubes fa-stack-1x"></i>
	// 			</span> CABANG - OUTLET',  
	// 		'type'=>'info',
	// 		//'before'=> tombolCreate().' '.tombolRefresh().' '.tombolExportExcel(),
	// 		'showFooter'=>false,
	// 	],
	// 	'floatOverflowContainer'=>true,
	// 	'floatHeader'=>true,
	// ]); 
	
?>
<div class="container-fluid" >
<?=$vewBreadcrumb?>
	<div class="col-xs-12 col-sm-12 col-lg-12" style="font-family: tahoma ;font-size: 9pt;">
		<div class="row">
			<?php //$gvStore?>
			</br>
			<?php
				//print_r(Yii::$app->getUserOpt->UserStore())
			?>
			
			</br>
			<?php
				/* echo TreeViewInput::widget([
					// single query fetch to render the tree
					// use the Product model you have in the previous step
					'query' => Product::find()->addOrderBy('root, lft'), 
					'headingOptions'=>['label'=>'Categories'],
					'name' => 'kv-product', // input name
					'value' => '1,2,3',     // values selected (comma separated for multiple select)
					'asDropdown' => true,   // will render the tree input widget as a dropdown.
					'multiple' => true,     // set to false if you do not need multiple selection
					'fontAwesome' => true,  // render font awesome icons
					'rootOptions' => [
						'label'=>'<i class="fa fa-tree"></i>',  // custom root label
						'class'=>'text-success'
					], 
					//'options'=>['disabled' => true],
				]); */
				// print_r($test);
				echo \kartik\tree\TreeView::widget([
					// 'id'=>'xx1',
					'query' => User::find()->where(['ACCESS_GROUP'=>$user])->addOrderBy('ACCESS_GROUP'),
					'headingOptions' => ['label' => 'User'],
					//'rootOptions' => ['label'=>'<span class="text-primary">Root</span>'],
					'rootOptions' => [
						'label'=>'<i class="fa fa-tree">PT.Trial</i>',  // custom root label
						'class'=>'text-success'
					], 
					'nodeAddlViews' => [
						\kartik\tree\Module::VIEW_PART_2 => '@frontend/frontend/backend/sistem/views/_form',
					],
					'fontAwesome' => false,
					'isAdmin' => true,
					'displayValue' => 1,
					'iconEditSettings'=> [
						'show' => 'list',
						'listData' => [
							'folder' => 'Folder',
							'file' => 'File',
							'mobile' => 'Phone',
							'bell' => 'Bell',
						]
					],
					//'softDelete' => false,
					// 'cacheSettings' => ['enableCache' => true],
					
				]); 
			?>
		</div>
	</div>
</div>