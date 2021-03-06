<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use common\models\Store;
use frontend\backend\master\models\ProductSearch;
use frontend\backend\master\models\CustomerSearch;
use frontend\backend\master\models\StoreKasirSearch;
use frontend\backend\hris\models\Karyawan;
use common\models\Userlogin;
	
	// $this->registerCss("
	// 	#expand-menu :link {
	// 		color:black;
	// 	}
	// 	//mouse over link
	// 	#expand-menu a:hover {
	// 		color: black;
	// 	}
	// 	//selected link
	// 	a:active {
	// 		color: black;
	// 	}
	// 	.kv-panel {
	// 		//min-height: 340px;
	// 		height: 300px;
	// 	}
	// 	// #expand-menu .kv-grid-container{
	// 		// height:250px
	// 	// }
	// ");

	// $headerColor='rgba(128, 179, 178, 1)';

	/*
	 * GRIDVIEW COLUMN
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.2
	*/	
				
	// $attDinamikMenu[]=[	
	// 	'class'=>'kartik\grid\ExpandRowColumn',
	// 	'width'=>'10px',
	// 	'header'=>'<span class="glyphicon glyphicon glyphicon-th-list"></span>',
	// 	'mergeHeader'=>true,
	// 	'allowBatchToggle'=>false,			
	// 	'value'=>function ($model, $key, $index, $column) {
	// 		return GridView::ROW_COLLAPSED;
	// 	},
	// 	'expandOneOnly'=>true,
	// 	'expandIcon'=>'<span class="glyphicon glyphicon-chevron-right"></span>',
	// 	'collapseIcon'=>'<span class="glyphicon glyphicon-chevron-down"></span>',
	// 	'expandTitle'=>'Click Icon',
	// 	'collapseTitle'=>'Click Icon',			
	// 	//'detailUrl'=>'/master/store/expand-detail',
	// 	//'expandRowKey'=>'1',
	// 	'detail'=>function ($model, $key, $index, $column){
	// 		$id=$model['id'];
	// 		$storeId=$model['STORE_ID']	;
	// 		$modelToko=Store::find()->where(['STORE_ID'=>$storeId])->One();
	// 		if($id==1){ 
	// 			//== Detail Toko ==				
	// 			if($modelToko){
	// 				return Yii::$app->controller->renderPartial('_detailToko',[
	// 					// 'storeId'=>$storeId,
	// 					// 'data'=>$model,
	// 					'modelToko'=>$modelToko
	// 				]);
	// 			}				
	// 		}elseif($id==2){
	// 			//== Detail Prodak==
	// 			$searchModel = new ProductSearch(['STORE_ID'=>$storeId]);
	// 			$dataProviderProdak = $searchModel->search(Yii::$app->request->queryParams);
	// 			return Yii::$app->controller->renderPartial('_detailProduk',[
	// 				'storeId'=>$storeId,
	// 				'dataProviderProdak'=>$dataProviderProdak
	// 			]);
	// 		}elseif($id==3){
	// 			//== Detail Pelanggan==
	// 			$searchModelPlg = new CustomerSearch(['STORE_ID'=>$storeId]);
	// 			$dataProviderPlg = $searchModelPlg->search(Yii::$app->request->queryParams);
	// 			return Yii::$app->controller->renderPartial('_detailPelanggan',[
	// 				//'storeId'=>$storeId,
	// 				'dataProviderPlg'=>$dataProviderPlg
	// 			]);
	// 		}elseif($id==4){
	// 			//== Detail Karyawan==
	// 			$searchModelKar = new KaryawanSearch(['STORE_ID'=>$storeId]);
	// 			$dataProviderKar = $searchModelKar->search(Yii::$app->request->queryParams);				
	// 			return Yii::$app->controller->renderPartial('_detailKaryawan',[
	// 				'storeId'=>$storeId,
	// 				'dataProviderKar'=>$dataProviderKar
	// 			]);
	// 		}elseif($id==5){
	// 			//== Detail User Operatioal==
	// 			// print_r($modelToko['ACCESS_ID']);die();
	// 			$modalUser=Userlogin::find()->Where('FIND_IN_SET(ACCESS_ID,"'.$modelToko['ACCESS_ID'].'")')->all();
	// 			$dataProviderUserOps= new ArrayDataProvider([
	// 				'allModels'=>$modalUser,	
	// 				'pagination' => [
	// 					'pageSize' => 200,
	// 				],
	// 			]);
	// 			return Yii::$app->controller->renderPartial('_detailUserOps',[
	// 				'storeId'=>$storeId,
	// 				'dataProviderUserOps'=>$dataProviderUserOps
	// 			]);
	// 		}
	// 	},
	// 	'headerOptions'=>[
	// 		'style'=>[
	// 			'text-align'=>'center',
	// 			'width'=>'10px',
	// 			'font-family'=>'verdana, arial, sans-serif',
	// 			'font-size'=>'10pt',
	// 			'background-color'=>$headerColor,
	// 			'color'=>'white',
	// 		]
	// 	],
	// 	'contentOptions'=>[
	// 		'style'=>[
	// 			'text-align'=>'center',
	// 			'width'=>'10px',
	// 			'font-family'=>'tahoma, arial, sans-serif',
	// 			'font-size'=>'10pt',
	// 		]
	// 	],			
	// ];
	
	// $attDinamikMenu[] =[
	// 	'attribute'=>'TITTLE_NM',
	// 	'filterType'=>true,
	// 	'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','250px'),
	// 	'hAlign'=>'right',
	// 	'vAlign'=>'middle',
	// 	'header'=>'Informasi '.$storeNm,
	// 	'mergeHeader'=>true,
	// 	'format'=>'html',
	// 	'noWrap'=>false,
	// 	'format'=>'raw',
	// 	// 'value'=>function($data) {				
	// 			// return Html::tag('div', $data->STORE_NM, ['data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Double click to Outlet Items ','style'=>'cursor:default;']);				
	// 	// },
	// 	'headerOptions'=>Yii::$app->gv->gvContainHeader('center','300px',$headerColor,'#ffffff'),
	// 	'contentOptions'=>Yii::$app->gv->gvContainBody('left','300px',''),			
	// ];
	
	// /* $attDinamikMenu[] =[
	// 	'attribute'=>'STORE_ID',
	// 	'filterType'=>true,
	// 	'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','250px'),
	// 	'hAlign'=>'right',
	// 	'vAlign'=>'middle',
	// 	'header'=>'INFO TOKO',
	// 	'mergeHeader'=>true,
	// 	'format'=>'html',
	// 	'noWrap'=>false,
	// 	'format'=>'raw',
	// 	// 'value'=>function($data) {				
	// 			// return Html::tag('div', $data->STORE_NM, ['data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Double click to Outlet Items ','style'=>'cursor:default;']);				
	// 	// },
	// 	'headerOptions'=>Yii::$app->gv->gvContainHeader('center','250px',$headerColor),
	// 	'contentOptions'=>Yii::$app->gv->gvContainBody('left','250px',''),			
	// ]; */
	
	// //ACTION
	// $attDinamikMenu[]=[
	// 	'class' => 'kartik\grid\ActionColumn',
	// 	'template' => '{view}',
	// 	'header'=>'ACTION',		
	// 	'headerOptions'=>[
	// 		'style'=>[
	// 			'text-align'=>'center',
	// 			'width'=>'5px',
	// 			'font-family'=>'verdana, arial, sans-serif',
	// 			'font-size'=>'10pt',
	// 			'background-color'=>$headerColor,
	// 			'color'=>'black',
	// 		]
	// 	],
	// 	'contentOptions'=>[
	// 		'style'=>[
	// 			'text-align'=>'center',
	// 			'width'=>'5px',
	// 			'font-family'=>'tahoma, arial, sans-serif',
	// 			'font-size'=>'10pt',
	// 			'color'=>'black',
	// 		]
	// 	],	
	// 	'buttons' => [
	// 		'view' =>function ($url,$model){
	// 			$id=$model['id'];
	// 			$storeId=$model['STORE_ID']	;
	// 			if ($id == 1){
	// 				$urlPilih='/master/product?storeid=170726220936.0001';
	// 			}elseif($id == 2){
	// 				$urlPilih='/master/product?storeid='.$storeId;
	// 			}else{
	// 				$urlPilih='';
	// 			}
	// 			return  tombolExpadDetail($urlPilih);
	// 		},
			
	// 	], 		
	// ];
	
	
	// $expandMenu= GridView::widget([
	// 	'id'=>'expand-menu',
	// 	'dataProvider' => $dataProviderMenu,
	// 	'columns' =>$attDinamikMenu,
	// 	'toolbar' => [
	// 		'{export}',
	// 	],
	// 	'panel'=>false,		
	// 	'pjax'=>true,
	// 	'pjaxSettings'=>[
	// 		'options'=>[
	// 			'enablePushState'=>false,
	// 			'id'=>'expand-menu',
	// 		],
	// 	],
	// 	'bootstrap'=>true,
	// 	'hover'=>true, //cursor select
	// 	'responsive'=>true,
	// 	'bordered'=>true,
	// 	'striped'=>true,
	// 	'export'=>[//export like view grid --ptr.nov-
	// 		'fontAwesome'=>true,
	// 		'showConfirmAlert'=>false,
	// 		'target'=>GridView::TARGET_BLANK
	// 	],
	// 	'summary'=>false,
	// ]);

	$id=Yii::$app->request->cookies;
	$storeId=$id->getValue('STORE_ID');
	// print_r($storeId);die();
	if (empty($storeId)) {
		$modelToko= new Store();
	} else {
		$modelToko= Store::find()->where(['STORE_ID'=>$storeId])->One();
	}
		
	$Action=$this->render('_detailToko',[
		'modelToko'=>$modelToko
	]);

	$searchModel = ProductSearch::find()->where(['STORE_ID'=>$storeId])->all();
	$dataProviderProdak= new ArrayDataProvider([
		'allModels'=>$searchModel,	
		'pagination' => [
			'pageSize' => 200,
		],
	]);
	$Action2=$this->render('_detailProduk',[
		'storeId'=>$storeId,
		'dataProviderProdak'=>$dataProviderProdak
	]);

	$searchModelPlg = CustomerSearch::find()->where(['STORE_ID'=>$storeId])->all();
	$dataProviderPlg= new ArrayDataProvider([
		'allModels'=>$searchModelPlg,	
		'pagination' => [
			'pageSize' => 200,
		],
	]);
	$Action3=$this->render('_detailPelanggan',[
		//'storeId'=>$storeId,
		'dataProviderPlg'=>$dataProviderPlg
	]);
		
	$searchModelKar = Karyawan::find()->where(['STORE_ID'=>$storeId])->all();
	$dataProviderKar= new ArrayDataProvider([
		'allModels'=>$searchModelKar,	
		'pagination' => [
			'pageSize' => 200,
		],
	]);				
	$Action4=$this->render('_detailKaryawan',[
		'storeId'=>$storeId,
		'dataProviderKar'=>$dataProviderKar
	]);
	$modalUser=Userlogin::find()->Where('ACCESS_LEVEL="OPS" AND FIND_IN_SET(ACCESS_ID,"'.$modelToko->ACCESS_ID.'")')->all();
		$dataProviderUserOps= new ArrayDataProvider([
			'allModels'=>$modalUser,	
			'pagination' => [
				'pageSize' => 200,
			],
		]);
		$Action5=$this->render('_detailUserOps',[
			'storeId'=>$storeId,
			'dataProviderUserOps'=>$dataProviderUserOps
		]);
		
	$modalStoreKasir=StoreKasirSearch::find()->where(['STORE_ID'=>$storeId])->all();;
		$dataProviderStoreKasir= new ArrayDataProvider([
			'allModels'=>$modalStoreKasir,	
			'pagination' => [
				'pageSize' => 200,
			],
		]);
		$Action6=$this->render('_detailStoreKasir',[
			'storeId'=>$storeId,
			'dataProviderStoreKasir'=>$dataProviderStoreKasir
		]);
	$items = [
		[
			'label'=>'<span class="fa-stack fa-sm text-left">
			<b class="fa fa-circle fa-stack-2x" style="color:#40B0B5"></b>
			<b class="fa fa-home fa-stack-1x" style="color:#FEFEFE"></b>
		  </span><b> RINCIAN TOKO </b>',
			'content'=>$Action,
			'active'=>true
		],
		[
			'label'=>'<span class="fa-stack fa-sm text-left">
			<b class="fa fa-circle fa-stack-2x" style="color:#40B0B5"></b>
			<b class="fa fa-product-hunt fa-stack-1x" style="color:#FEFEFE"></b>
		  </span><b> DAFTAR PRODUK </b>',
			'content'=>$Action2
		],
		[
			'label'=>'<span class="fa-stack fa-sm text-left">
			<b class="fa fa-circle fa-stack-2x" style="color:#40B0B5"></b>
			<b class="fa fa-users fa-stack-1x" style="color:#FEFEFE"></b>
		  </span><b> DAFTAR PELANGGAN </b>',
			'content'=>$Action3
		],
		[
			'label'=>'<span class="fa-stack fa-sm text-left">
			<b class="fa fa-circle fa-stack-2x" style="color:#40B0B5"></b>
			<b class="fa fa-user fa-stack-1x" style="color:#FEFEFE"></b>
		  </span><b> DAFTAR KARAWAN </b>',
			'content'=>$Action4
		],
		[
			'label'=>'<span class="fa-stack fa-sm text-left">
			<b class="fa fa-circle fa-stack-2x" style="color:#40B0B5"></b>
			<b class="fa fa-user-secret fa-stack-1x" style="color:#FEFEFE"></b>
		  </span><b> DAFTAR USER LOGIN </b>',
			'content'=>$Action5
		],
		[
			'label'=>'<span class="fa-stack fa-sm text-left">
			<b class="fa fa-circle fa-stack-2x" style="color:#40B0B5"></b>
			<b class="fa fa-mobile fa-stack-1x" style="color:#FEFEFE"></b>
		  </span><b> PERANGKAT KASIR </b>',
			'content'=>$Action6
		],
	];
	
	$tabIndex=TabsX::widget([
		'items'=>$items,
		'enableStickyTabs'=>true,
		'encodeLabels'=>false
	]);
?>
<?=$tabIndex?>