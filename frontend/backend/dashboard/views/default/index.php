<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use kartik\widgets\Growl;
use yii\web\View;

use frontend\backend\dashboard\models\StoreKasirSearch;

ChartAsset::register($this);
$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

	$this->registerJs($this->render('script.js'),View::POS_READY);
	echo $this->render('button'); //echo difinition
    echo $this->render('modal'); //echo difinition
	
//print_r(Yii::$app->getUserOpt->user());
	$_indexChart1=$this->render('_indexChart1',[
		'totalGrandHari'=>'100',//$totalGrandHari,
		'totalTransHari'=>'1000.000',//$totalTransHari,
		'totalMember'=>'100',//$totalMember
	]);

	/* $items=[
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Sales Rasa-Sayang','content'=>
			$_indexChart1,
			// $_indexSalesWeekHour.
			// $_indexSalesWeek.						
			// $_indexSalesYear.
			// $_indexTop5MemberTenanMonth,
			'active'=>true,			
		],		
		
	]; */	


	// $tabDashboard= TabsX::widget([
			// 'items'=>$items,
			// 'position'=>TabsX::POS_ABOVE,
			// 'height'=>TabsX::SIZE_TINY,
			// 'bordered'=>true,
			// 'encodeLabels'=>false,
			// 'height'=>'450px',
			// 'align'=>TabsX::ALIGN_LEFT,						
		// ]);	
		$user = (empty(Yii::$app->user->identity->ACCESS_GROUP)) ? '' : Yii::$app->user->identity->ACCESS_GROUP;
    	$searchModel = new StoreKasirSearch(['ACCESS_GROUP'=>$user]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model=$dataProvider->getModels();
		
		
	?>
<div id="loaderPtr"></div>


<?php

/* 	//$client = new \GuzzleHttp\Client();
	$client = new \GuzzleHttp\Client([
		'headers' => [ 'Content-Type' => 'application/json' ]
	]);
	$dataBody = [			
			"ACCESS_GROUP" => "170726220936"		
	];
	$res = $client->post('192.168.212.101/laporan/counters/per-access-group',
						[
							'body' =>json_encode($dataBody)
						]);
	// echo $res->getStatusCode();
	// echo $res->getBody();
	//$data=$res->getBody();
	//echo $data->CNT_STORE_AKTIF;
	$data1=json_decode($res->getBody());
	$data2=json_decode($res->getBody())->PER_ACCESS_GROUP;
	$data=json_decode($res->getBody())->PER_ACCESS_GROUP[0];
	$rslt=$data->ACCESS_GROUP;
	echo $rslt;
	//die();  */
		


// print_r($model);die();
	foreach ($model as $key) {
		$tglbayar = strtotime($key->DATE_START);
		$tglsekarang = strtotime(date('Y-m-d'));
		$jatuhtempo = strtotime($key->DATE_END);
		
		// hitung perbedaan  jatuh tempo dengan sekarang 
		$beda = $jatuhtempo - $tglsekarang; // unix time
		// konversi $beda kedalam hari
		$bedahari = ($beda/(24*60*60));
		// print_r($bedahari);die();
		if ($beda > 0 ){
			if ($bedahari < 8 ) {
				echo Growl::widget([
					'type' => Growl::TYPE_DANGER,
					'title' => 'Oh snap!',
					'icon' => '	fa fa-exclamation-triangle',
					'body' => 'Pernagkata '.$key->KASIR_NM.'Masa berlaku akan habis',
					'showSeparator' => true,
					'delay' => 5500,
					'pluginOptions' => [
						'showProgressbar' => true,
						'placement' => [
							'from' => 'top',
							'align' => 'right',
						]
					]
				]);
			}
		}		
	}
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
			<?=$_indexChart1?>
</div>