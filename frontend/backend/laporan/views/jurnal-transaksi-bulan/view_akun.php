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
use yii\web\View;
use kartik\widgets\Alert;
use frontend\backend\laporan\models\JurnalTransaksiBulan;

$user = (empty(Yii::$app->user->identity->ACCESS_GROUP)) ? '' : Yii::$app->user->identity->ACCESS_GROUP;    
// print_r($dataProvider->getModels());
// die();
$this->title = 'Jurnal Transaksi Bulans';
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
	");
	// $this->registerJs($this->render('jurnal_script.js'),View::POS_READY);
	// echo $this->render('jurnal_button'); //echo difinition
    // echo $this->render('jurnal_modal'); //echo difinition
    $bColor='rgb(76, 131, 255)';	
    $gvAttProdakDiscountItem=[
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','30px',$bColor,'#ffffff'),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','30px',''),
		],
		[
			'attribute'=>'AKUN_CODE',
			'label'=>'Code Akun',
			'filterType'=>true,
			'format'=>'raw',
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','80px'),
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>false,
            'group'=>FALSE,
			'groupedRow'=>FALSE,
			'noWrap'=>false,
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','100px',$bColor,'#ffffff'),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','200px',''),
		],	
		[
			'attribute'=>'AKUN_NM',
			'label'=>'Nama Akun',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','200px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','200px',$bColor,'#ffffff'),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','200px',''),			
		],			
		[
			'attribute'=>'KTG_NM',
			'label'=>'Kategori',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','100px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','100px',$bColor,'#ffffff'),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','100px',''),
			
		],			
		//DEFAULT_STOCK
		// [
			// 'attribute'=>'KETERANGAN',
			// 'label'=>'STATUS PAY',
			// 'filterType'=>true,
			// 'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','100px'),
			// 'hAlign'=>'right',
			// 'vAlign'=>'middle',
			// 'mergeHeader'=>false,
			// 'noWrap'=>false,
			////gvContainHeader($align,$width,$bColor)
			// 'headerOptions'=>Yii::$app->gv->gvContainHeader('center','100px',$bColor,'#ffffff'),
			// 'contentOptions'=>Yii::$app->gv->gvContainBody('left','100px',''),
			
		// ],
	];
	$pageNm='<span class="fa-stack fa-xs text-left" style="float:left">
			  <b class="fa fa-list-alt fa-stack-2x" style="color:#000000"></b>
			 </span> <div style="float:left;padding:10px 20px 0px 5px"><b>JURNAL TRANSAKSI</b></div> 
			 ';	
	$gvInvOut= GridView::widget([
		'id'=>'jurnal-transaksi-akun',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
		'columns' =>$gvAttProdakDiscountItem,	
		'toolbar' => [
			'{export}',
		],	
		'pjax'=>false,
	    'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'jurnal-transaksi-akun',
			],
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
		'export'=>[//export like view grid --ptr.nov-
			'fontAwesome'=>true,
			'showConfirmAlert'=>false,
			'target'=>GridView::TARGET_BLANK
		],
		'summary'=>false,
		//'floatHeader'=>false,
		// 'floatHeaderOptions'=>['scrollingTop'=>'200'] 
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
	]);
?>
    <?=$gvInvOut?>