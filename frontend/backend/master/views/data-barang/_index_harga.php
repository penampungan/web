<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\widgets\Spinner;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel frontend\backend\master\models\ProductHargaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$pageNm='<span class="fa-stack fa-xs text-right">				  
				  <i class="fa fa-share fa-1x"></i>
				</span><b>PRODUCT HARGA JATUH TEMPO</b>
	';
?>
<div class="product-harga-index">

    <?= GridView::widget([
        'dataProvider' => $dataProviderHarga,
        'filterModel' => $searchModelHarga,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'ACCESS_GROUP',
            'STORE_ID',
            'PRODUCT_ID',
            'PERIODE_TGL1',
            //'PERIODE_TGL2',
            //'START_TIME',
            //'HPP',
            //'HARGA_JUAL',
            //'CREATE_BY',
            //'CREATE_AT',
            //'UPDATE_BY',
            //'UPDATE_AT',
            //'STATUS',
            //'DCRP_DETIL:ntext',
            //'YEAR_AT',
            //'MONTH_AT',

            ['class' => 'yii\grid\ActionColumn'],
		],
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-all-data-store-item',
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
		'toolbar' => false,
		'panel' => [
			// 'heading'=>false,
			'heading'=>'<div style="float:right"> </div>'.$pageNm,
			'type'=>'success',
			'before'=>false,
			'showFooter'=>false,
		],
    ]); ?>
</div>
