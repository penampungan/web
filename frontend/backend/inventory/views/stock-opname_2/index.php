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

$this->title='Stok Opname';
	$this->registerCss("
		#prodak-stok-opname .kv-grid-container{
			height:500px
		}
		
		#prodak-stok-opname .panel-heading {
			background: linear-gradient( 135deg, #2AFADF 10%, #4C83FF 100%);
			color:#000;
		}
		#prodak-stok-opname .panel-footer {
			background: linear-gradient( 135deg, #2AFADF 10%, #4C83FF 100%);
		}
	");
	$this->registerJs($this->render('stockopname_script.js'),View::POS_READY);
	echo $this->render('stockopname_button'); //echo difinition
	echo $this->render('stockopname_modal'); //echo difinition
	$pageNm='<span class="fa-stack fa-xs text-left" style="float:left">
			  <b class="fa fa-edit fa-stack-2x" style="color:#000000"></b>
			 </span> <div style="float:left;padding:10px 20px 0px 5px"><b>STOK OPNAME</b></div> 
	';
				
	$colorHeader='rgba(230, 230, 230, 1)';
	$colorHeader1='rgba(140, 140, 140, 1)';
	$colorHeader2='rgba(230, 230, 230, 1)';
	$dinamikField=$dataProvider->getModels();
	//$tanggal=$dinamikField[0]['TAHUN'].'-'.$dinamikField[0]['BULAN'].'-01';
	
	
	$attDinamikField[] =[			
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9px',
					//'background-color'=>$bColor,
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'10px',
				]
			],					
	];
	
	$aryFieldColomn[]=['ID' =>0, 'ATTR' =>['FIELD'=>'STORE_ID','SIZE' => '10px','WIDTH'=>'50px','label'=>'TOKO1','align'=>'left','group'=>true,'pageSummary'=>false]];
	// $aryFieldColomn[]=['ID' =>1, 'ATTR' =>['FIELD'=>'STORE_NM','SIZE' => '9px','WIDTH'=>'50px','label'=>'TOKO','align'=>'left','group'=>false,'pageSummary'=>false]];
	$aryFieldColomn[]=['ID' =>1, 'ATTR' =>['FIELD'=>'PRODUK','SIZE' => '9px','WIDTH'=>'50px','label'=>'PRODUK','align'=>'left','group'=>false,'pageSummary'=>false]];
	$headerContent1[]=['content'=>'DATA PRODUK','options'=>['colspan'=>3,'class'=>'text-center','style'=>'width:14px;background-color:'.$colorHeader1.';font-family: tahoma ;font-size: 6pt;']];
	$aryFieldColomn[]=['ID' =>2, 'ATTR' =>['FIELD'=>'TTL_LALU','SIZE' => '9px','WIDTH'=>'50px','label'=>'LALU','align'=>'right','group'=>false,'pageSummary'=>false]];
	$aryFieldColomn[]=['ID' =>3, 'ATTR' =>['FIELD'=>'TTL_MASUK','SIZE' => '9px','WIDTH'=>'50px','label'=>'MASUK','align'=>'right','group'=>false,'pageSummary'=>false]];
	$aryFieldColomn[]=['ID' =>4, 'ATTR' =>['FIELD'=>'TTL_JUAL','SIZE' => '9px','WIDTH'=>'50px','label'=>'TERJUAL','align'=>'right','group'=>false,'pageSummary'=>false]];
	$aryFieldColomn[]=['ID' =>5, 'ATTR' =>['FIELD'=>'TTL_SISA','SIZE' => '9px','WIDTH'=>'50px','label'=>'SISA','align'=>'right','group'=>false,'pageSummary'=>false]];
	$headerContent1[]=['content'=>'TOTAL STOK','options'=>['colspan'=>4,'WIDTH'=>'50px','class'=>'text-center','style'=>'background-color:'.$colorHeader1.';font-family: tahoma ;font-size: 6pt;']];
	 //OPNAME
	$aryFieldColomn[]=['ID' =>6, 'ATTR' =>['FIELD'=>'Closing','SIZE' => '9px','label'=>'Closing','align'=>'right','group'=>false,'pageSummary'=>false,'BCOLOR'=>$colorHeader]];
	$aryFieldColomn[]=['ID' =>7, 'ATTR' =>['FIELD'=>'Actual','SIZE' => '9px','label'=>'Actual','align'=>'right','group'=>false,'pageSummary'=>false,'BCOLOR'=>$colorHeader]];
	$headerContent1[]=['content'=>'STOK OPNAME','options'=>['colspan'=>2,'class'=>'text-center','style'=>'background-color:'.$colorHeader1.';font-family: tahoma ;font-size: 6pt;']];		

	$valFields = ArrayHelper::map($aryFieldColomn, 'ID', 'ATTR');
	foreach($valFields as $key =>$value[]){	
		if ($value[$key]['FIELD']=='PRODUK' OR $value[$key]['FIELD']=='NAMA_TOKO'){
			$attDinamikField[]=[
				'attribute'=>$value[$key]['FIELD'],
				'label'=>$value[$key]['label'],
				// 'filterType'=>$gvfilterType,
				// 'filter'=>$gvfilter,
				// 'filterWidgetOptions'=>$filterWidgetOpt,	
				//'filterInputOptions'=>$filterInputOpt,				
				'hAlign'=>'right',
				'vAlign'=>'middle',
				'hidden'=>false,
				'noWrap'=>true,	
				'value'=>function($data)use($key,$value){
					$x=$value[$key]['FIELD'];	
					$splt=explode('_',$x);
					//if($splt[0]=='SISA'){					
					if($x=='STORE_ID'){
						return 'NAMA TOKO :  '.$data['STORE_NM'];
					}else{						
						if($data[$x]){
							return $data[$x];
						}else{
							return 0;
						}						
					}		
				},							
				'headerOptions'=>[		
					'style'=>[									
						'text-align'=>'center',
						'width'=>$value[$key]['WIDTH'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8px',
						//'background-color'=>$value[$key]['BCOLOR'],
						//'color'=>'#5a96e7'
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>$value[$key]['SIZE'],
						'font-weight'=>'bold',
					]
				],				
				'group'=>$value[$key]['group'],
				'groupedRow'=>true,
				'groupFooter'=>function($model, $key, $index, $widget){ 
					return [
						'mergeColumns'=>[[2,2]], 
						'content'=>[             // content to show in each summary cell
							2=>'TOTAL KESELURUHAN',
							3=>GridView::F_SUM,4=>GridView::F_SUM,5=>GridView::F_SUM,6=>GridView::F_SUM,7=>GridView::F_SUM,8=>GridView::F_SUM,9=>GridView::F_SUM,10=>GridView::F_SUM,
							11=>GridView::F_SUM,12=>GridView::F_SUM,13=>GridView::F_SUM,14=>GridView::F_SUM,15=>GridView::F_SUM,16=>GridView::F_SUM,17=>GridView::F_SUM,18=>GridView::F_SUM,19=>GridView::F_SUM,20=>GridView::F_SUM,							
							21=>GridView::F_SUM,22=>GridView::F_SUM,23=>GridView::F_SUM,24=>GridView::F_SUM,25=>GridView::F_SUM,26=>GridView::F_SUM,27=>GridView::F_SUM,28=>GridView::F_SUM,29=>GridView::F_SUM,30=>GridView::F_SUM,
							31=>GridView::F_SUM,32=>GridView::F_SUM,33=>GridView::F_SUM,34=>GridView::F_SUM,35=>GridView::F_SUM,36=>GridView::F_SUM,37=>GridView::F_SUM,38=>GridView::F_SUM,39=>GridView::F_SUM,40=>GridView::F_SUM,												
							41=>GridView::F_SUM,42=>GridView::F_SUM,43=>GridView::F_SUM,44=>GridView::F_SUM,45=>GridView::F_SUM,46=>GridView::F_SUM,47=>GridView::F_SUM,48=>GridView::F_SUM,49=>GridView::F_SUM,50=>GridView::F_SUM,					
							51=>GridView::F_SUM,52=>GridView::F_SUM,53=>GridView::F_SUM,54=>GridView::F_SUM,55=>GridView::F_SUM,56=>GridView::F_SUM,57=>GridView::F_SUM,58=>GridView::F_SUM,59=>GridView::F_SUM,60=>GridView::F_SUM,					
							61=>GridView::F_SUM,62=>GridView::F_SUM,63=>GridView::F_SUM,64=>GridView::F_SUM,65=>GridView::F_SUM,66=>GridView::F_SUM,67=>GridView::F_SUM,68=>GridView::F_SUM,69=>GridView::F_SUM,70=>GridView::F_SUM,					
							71=>GridView::F_SUM,72=>GridView::F_SUM,73=>GridView::F_SUM,74=>GridView::F_SUM,75=>GridView::F_SUM,76=>GridView::F_SUM,77=>GridView::F_SUM,78=>GridView::F_SUM,79=>GridView::F_SUM,80=>GridView::F_SUM,					
							81=>GridView::F_SUM,82=>GridView::F_SUM,83=>GridView::F_SUM,84=>GridView::F_SUM,85=>GridView::F_SUM,86=>GridView::F_SUM,87=>GridView::F_SUM,88=>GridView::F_SUM,89=>GridView::F_SUM,90=>GridView::F_SUM,					
							91=>GridView::F_SUM,92=>GridView::F_SUM,93=>GridView::F_SUM,94=>GridView::F_SUM,95=>GridView::F_SUM,96=>GridView::F_SUM,97=>GridView::F_SUM,98=>GridView::F_SUM,99=>GridView::F_SUM,100=>GridView::F_SUM,																	
						],
						'contentFormats'=>[      // content html attributes for each summary cell
							3=>['format'=>'number','decimals'=>2], 4=>['format'=>'number','decimals'=>2], 5=>['format'=>'number','decimals'=>2], 6=>['format'=>'number','decimals'=>2], 7=>['format'=>'number','decimals'=>2],8=>['format'=>'number','decimals'=>2], 9=>['format'=>'number','decimals'=>2], 10=>['format'=>'number','decimals'=>2], 
							11=>['format'=>'number','decimals'=>2], 12=>['format'=>'number','decimals'=>2],13=>['format'=>'number','decimals'=>2], 14=>['format'=>'number','decimals'=>2], 15=>['format'=>'number','decimals'=>2], 16=>['format'=>'number','decimals'=>2], 17=>['format'=>'number','decimals'=>2], 18=>['format'=>'number','decimals'=>2], 19=>['format'=>'number','decimals'=>2], 20=>['format'=>'number','decimals'=>2], 
							21=>['format'=>'number','decimals'=>2], 22=>['format'=>'number','decimals'=>2],23=>['format'=>'number','decimals'=>2], 24=>['format'=>'number','decimals'=>2], 25=>['format'=>'number','decimals'=>2], 26=>['format'=>'number','decimals'=>2], 27=>['format'=>'number','decimals'=>2], 28=>['format'=>'number','decimals'=>2], 29=>['format'=>'number','decimals'=>2], 30=>['format'=>'number','decimals'=>2], 
							31=>['format'=>'number','decimals'=>2], 32=>['format'=>'number','decimals'=>2],33=>['format'=>'number','decimals'=>2], 34=>['format'=>'number','decimals'=>2], 35=>['format'=>'number','decimals'=>2], 36=>['format'=>'number','decimals'=>2], 37=>['format'=>'number','decimals'=>2], 38=>['format'=>'number','decimals'=>2], 39=>['format'=>'number','decimals'=>2], 40=>['format'=>'number','decimals'=>2], 
							41=>['format'=>'number','decimals'=>2], 42=>['format'=>'number','decimals'=>2],43=>['format'=>'number','decimals'=>2], 44=>['format'=>'number','decimals'=>2], 45=>['format'=>'number','decimals'=>2], 46=>['format'=>'number','decimals'=>2], 47=>['format'=>'number','decimals'=>2], 48=>['format'=>'number','decimals'=>2], 49=>['format'=>'number','decimals'=>2], 50=>['format'=>'number','decimals'=>2], 
							51=>['format'=>'number','decimals'=>2], 52=>['format'=>'number','decimals'=>2],53=>['format'=>'number','decimals'=>2], 54=>['format'=>'number','decimals'=>2], 55=>['format'=>'number','decimals'=>2], 56=>['format'=>'number','decimals'=>2], 57=>['format'=>'number','decimals'=>2], 58=>['format'=>'number','decimals'=>2], 59=>['format'=>'number','decimals'=>2], 60=>['format'=>'number','decimals'=>2], 
							61=>['format'=>'number','decimals'=>2], 62=>['format'=>'number','decimals'=>2],63=>['format'=>'number','decimals'=>2], 64=>['format'=>'number','decimals'=>2], 65=>['format'=>'number','decimals'=>2], 66=>['format'=>'number','decimals'=>2], 67=>['format'=>'number','decimals'=>2], 68=>['format'=>'number','decimals'=>2], 69=>['format'=>'number','decimals'=>2], 70=>['format'=>'number','decimals'=>2], 
							71=>['format'=>'number','decimals'=>2], 72=>['format'=>'number','decimals'=>2],73=>['format'=>'number','decimals'=>2], 74=>['format'=>'number','decimals'=>2], 75=>['format'=>'number','decimals'=>2], 76=>['format'=>'number','decimals'=>2], 77=>['format'=>'number','decimals'=>2], 78=>['format'=>'number','decimals'=>2], 79=>['format'=>'number','decimals'=>2], 80=>['format'=>'number','decimals'=>2], 
							81=>['format'=>'number','decimals'=>2], 82=>['format'=>'number','decimals'=>2],83=>['format'=>'number','decimals'=>2], 84=>['format'=>'number','decimals'=>2], 85=>['format'=>'number','decimals'=>2], 86=>['format'=>'number','decimals'=>2], 87=>['format'=>'number','decimals'=>2], 88=>['format'=>'number','decimals'=>2], 89=>['format'=>'number','decimals'=>2], 90=>['format'=>'number','decimals'=>2], 
							91=>['format'=>'number','decimals'=>2], 92=>['format'=>'number','decimals'=>2],93=>['format'=>'number','decimals'=>2], 94=>['format'=>'number','decimals'=>2], 95=>['format'=>'number','decimals'=>2], 96=>['format'=>'number','decimals'=>2], 97=>['format'=>'number','decimals'=>2], 98=>['format'=>'number','decimals'=>2], 99=>['format'=>'number','decimals'=>2], 100=>['format'=>'number','decimals'=>2], 
						] 	,
						'contentOptions'=>[      // content html attributes for each summary cell
							2=>['style'=>'text-align:right;font-size:9px;font-weight:bold;color:#243852'],
							// 6=>['style'=>'font-variant:small-caps;text-align:right;color:white','font-size'=>'8pt'],
							// 8=>['style'=>'font-variant:small-caps;text-align:right;color:white','font-size'=>'8pt'],
							// 9=>['style'=>'font-variant:small-caps;text-align:right;color:white','font-size'=>'8pt'],
						],
						'options'=>['class'=>'info','style'=>'id:header-sales-trans-x1,font-weight:bold;font-size:8px;text-align:right;']
					];
				},
				
			];
		}else{
			$attDinamikField[]=[		
				'attribute'=>$value[$key]['FIELD'],
				'label'=>$value[$key]['label'],
				// 'filterType'=>$gvfilterType,
				// 'filter'=>$gvfilter,
				// 'filterWidgetOptions'=>$filterWidgetOpt,	
				//'filterInputOptions'=>$filterInputOpt,				
				'hAlign'=>'right',
				'vAlign'=>'middle',
				'noWrap'=>true,	
				'value'=>function($data)use($key,$value){
					$x=$value[$key]['FIELD'];	
					$splt=explode('_',$x);
					//if($splt[0]=='SISA'){					
					if($x=='STORE_ID'){
						return 'NAMA TOKO :  '.$data['STORE_NM'];
					}else{						
						if($data[$x]){
							return $data[$x];
						}else{
							return 0;
						}						
					}		
				},					
				'headerOptions'=>[		
						'style'=>[									
						'text-align'=>'center',
						'width'=>'20px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8px',
						//'background-color'=>$value[$key]['BCOLOR'],
					]
				],  
				//'format'=>['decimal', 2],
				'format' => 'raw',
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>$value[$key]['SIZE'],
						'font-weight'=>'bold',
						]
				],				
				'group'=>$value[$key]['group'],
				'groupedRow'=>true,
				'groupFooter'=>function($model, $key, $index, $widget){ 
					return [
						'mergeColumns'=>[[2,2]], 
						'content'=>[             // content to show in each summary cell
							2=>'TOTAL KESELURUHAN',
							3=>GridView::F_SUM,4=>GridView::F_SUM,5=>GridView::F_SUM,6=>GridView::F_SUM,7=>GridView::F_SUM,8=>GridView::F_SUM,9=>GridView::F_SUM,10=>GridView::F_SUM,
							11=>GridView::F_SUM,12=>GridView::F_SUM,13=>GridView::F_SUM,14=>GridView::F_SUM,15=>GridView::F_SUM,16=>GridView::F_SUM,17=>GridView::F_SUM,18=>GridView::F_SUM,19=>GridView::F_SUM,20=>GridView::F_SUM,							
							21=>GridView::F_SUM,22=>GridView::F_SUM,23=>GridView::F_SUM,24=>GridView::F_SUM,25=>GridView::F_SUM,26=>GridView::F_SUM,27=>GridView::F_SUM,28=>GridView::F_SUM,29=>GridView::F_SUM,30=>GridView::F_SUM,
							31=>GridView::F_SUM,32=>GridView::F_SUM,33=>GridView::F_SUM,34=>GridView::F_SUM,35=>GridView::F_SUM,36=>GridView::F_SUM,37=>GridView::F_SUM,38=>GridView::F_SUM,39=>GridView::F_SUM,40=>GridView::F_SUM,												
							41=>GridView::F_SUM,42=>GridView::F_SUM,43=>GridView::F_SUM,44=>GridView::F_SUM,45=>GridView::F_SUM,46=>GridView::F_SUM,47=>GridView::F_SUM,48=>GridView::F_SUM,49=>GridView::F_SUM,50=>GridView::F_SUM,					
							51=>GridView::F_SUM,52=>GridView::F_SUM,53=>GridView::F_SUM,54=>GridView::F_SUM,55=>GridView::F_SUM,56=>GridView::F_SUM,57=>GridView::F_SUM,58=>GridView::F_SUM,59=>GridView::F_SUM,60=>GridView::F_SUM,					
							61=>GridView::F_SUM,62=>GridView::F_SUM,63=>GridView::F_SUM,64=>GridView::F_SUM,65=>GridView::F_SUM,66=>GridView::F_SUM,67=>GridView::F_SUM,68=>GridView::F_SUM,69=>GridView::F_SUM,70=>GridView::F_SUM,					
							71=>GridView::F_SUM,72=>GridView::F_SUM,73=>GridView::F_SUM,74=>GridView::F_SUM,75=>GridView::F_SUM,76=>GridView::F_SUM,77=>GridView::F_SUM,78=>GridView::F_SUM,79=>GridView::F_SUM,80=>GridView::F_SUM,					
							81=>GridView::F_SUM,82=>GridView::F_SUM,83=>GridView::F_SUM,84=>GridView::F_SUM,85=>GridView::F_SUM,86=>GridView::F_SUM,87=>GridView::F_SUM,88=>GridView::F_SUM,89=>GridView::F_SUM,90=>GridView::F_SUM,					
							91=>GridView::F_SUM,92=>GridView::F_SUM,93=>GridView::F_SUM,94=>GridView::F_SUM,95=>GridView::F_SUM,96=>GridView::F_SUM,97=>GridView::F_SUM,98=>GridView::F_SUM,99=>GridView::F_SUM,100=>GridView::F_SUM,																	
						],
						'contentFormats'=>[      // content html attributes for each summary cell
							3=>['format'=>'number','decimals'=>2], 4=>['format'=>'number','decimals'=>2], 5=>['format'=>'number','decimals'=>2], 6=>['format'=>'number','decimals'=>2], 7=>['format'=>'number','decimals'=>2],8=>['format'=>'number','decimals'=>2], 9=>['format'=>'number','decimals'=>2], 10=>['format'=>'number','decimals'=>2], 
							11=>['format'=>'number','decimals'=>2], 12=>['format'=>'number','decimals'=>2],13=>['format'=>'number','decimals'=>2], 14=>['format'=>'number','decimals'=>2], 15=>['format'=>'number','decimals'=>2], 16=>['format'=>'number','decimals'=>2], 17=>['format'=>'number','decimals'=>2], 18=>['format'=>'number','decimals'=>2], 19=>['format'=>'number','decimals'=>2], 20=>['format'=>'number','decimals'=>2], 
							21=>['format'=>'number','decimals'=>2], 22=>['format'=>'number','decimals'=>2],23=>['format'=>'number','decimals'=>2], 24=>['format'=>'number','decimals'=>2], 25=>['format'=>'number','decimals'=>2], 26=>['format'=>'number','decimals'=>2], 27=>['format'=>'number','decimals'=>2], 28=>['format'=>'number','decimals'=>2], 29=>['format'=>'number','decimals'=>2], 30=>['format'=>'number','decimals'=>2], 
							31=>['format'=>'number','decimals'=>2], 32=>['format'=>'number','decimals'=>2],33=>['format'=>'number','decimals'=>2], 34=>['format'=>'number','decimals'=>2], 35=>['format'=>'number','decimals'=>2], 36=>['format'=>'number','decimals'=>2], 37=>['format'=>'number','decimals'=>2], 38=>['format'=>'number','decimals'=>2], 39=>['format'=>'number','decimals'=>2], 40=>['format'=>'number','decimals'=>2], 
							41=>['format'=>'number','decimals'=>2], 42=>['format'=>'number','decimals'=>2],43=>['format'=>'number','decimals'=>2], 44=>['format'=>'number','decimals'=>2], 45=>['format'=>'number','decimals'=>2], 46=>['format'=>'number','decimals'=>2], 47=>['format'=>'number','decimals'=>2], 48=>['format'=>'number','decimals'=>2], 49=>['format'=>'number','decimals'=>2], 50=>['format'=>'number','decimals'=>2], 
							51=>['format'=>'number','decimals'=>2], 52=>['format'=>'number','decimals'=>2],53=>['format'=>'number','decimals'=>2], 54=>['format'=>'number','decimals'=>2], 55=>['format'=>'number','decimals'=>2], 56=>['format'=>'number','decimals'=>2], 57=>['format'=>'number','decimals'=>2], 58=>['format'=>'number','decimals'=>2], 59=>['format'=>'number','decimals'=>2], 60=>['format'=>'number','decimals'=>2], 
							61=>['format'=>'number','decimals'=>2], 62=>['format'=>'number','decimals'=>2],63=>['format'=>'number','decimals'=>2], 64=>['format'=>'number','decimals'=>2], 65=>['format'=>'number','decimals'=>2], 66=>['format'=>'number','decimals'=>2], 67=>['format'=>'number','decimals'=>2], 68=>['format'=>'number','decimals'=>2], 69=>['format'=>'number','decimals'=>2], 70=>['format'=>'number','decimals'=>2], 
							71=>['format'=>'number','decimals'=>2], 72=>['format'=>'number','decimals'=>2],73=>['format'=>'number','decimals'=>2], 74=>['format'=>'number','decimals'=>2], 75=>['format'=>'number','decimals'=>2], 76=>['format'=>'number','decimals'=>2], 77=>['format'=>'number','decimals'=>2], 78=>['format'=>'number','decimals'=>2], 79=>['format'=>'number','decimals'=>2], 80=>['format'=>'number','decimals'=>2], 
							81=>['format'=>'number','decimals'=>2], 82=>['format'=>'number','decimals'=>2],83=>['format'=>'number','decimals'=>2], 84=>['format'=>'number','decimals'=>2], 85=>['format'=>'number','decimals'=>2], 86=>['format'=>'number','decimals'=>2], 87=>['format'=>'number','decimals'=>2], 88=>['format'=>'number','decimals'=>2], 89=>['format'=>'number','decimals'=>2], 90=>['format'=>'number','decimals'=>2], 
							91=>['format'=>'number','decimals'=>2], 92=>['format'=>'number','decimals'=>2],93=>['format'=>'number','decimals'=>2], 94=>['format'=>'number','decimals'=>2], 95=>['format'=>'number','decimals'=>2], 96=>['format'=>'number','decimals'=>2], 97=>['format'=>'number','decimals'=>2], 98=>['format'=>'number','decimals'=>2], 99=>['format'=>'number','decimals'=>2], 100=>['format'=>'number','decimals'=>2], 
						] 	,
						'contentOptions'=>[      // content html attributes for each summary cell
							2=>['style'=>'text-align:right;font-size:9px;font-weight:bold;color:#243852'],
							// 6=>['style'=>'font-variant:small-caps;text-align:right;color:white','font-size'=>'8pt'],
							// 8=>['style'=>'font-variant:small-caps;text-align:right;color:white','font-size'=>'8pt'],
							// 9=>['style'=>'font-variant:small-caps;text-align:right;color:white','font-size'=>'8pt'],
						],
						'options'=>['class'=>'info','style'=>'id:header-sales-trans-x1,font-weight:bold;font-size:8px;text-align:right;']
					];
				},
							
			];	
		}
	};
	
	
	$gvProdukStockOpname= GridView::widget([
		'id'=>'prodak-stok-opname',
		'dataProvider' => $dataProvider,
		//'filterModel' => $searchModelDetail,
		'filterRowOptions'=>['style'=>'background-color:'.$colorHeader.'; align:center'],
		'beforeHeader'=>[
			'0'=>[					
				'columns'=>$headerContent1,
			]
		],
		'columns' =>$attDinamikField,	
		'toolbar' => [
			'{export}',
		],	
		'panel'=>[
			'type'=>'info',
			'heading'=>$pageNm.'<div style="float:right;padding:0px 10px 0px 5px">'.tombolSearchPeriode().' <i class="fa fa-toggle-right"></i> '.tombolClosingStock($paramCari).' <i class="fa fa-toggle-right"></i> '.tombolDownloadFormat($paramCari).' <i class="fa fa-toggle-right"></i> '.tombolUploadFormat().' <i class="fa fa-toggle-right"></i> '.tombolExportExcel($paramCari).'</div> ',
			'before'=>false,
			'after'=>false			
		],
		'pjax'=>false,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'prodak-stok-opname',
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
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
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
	<div class="col-xs-12 col-sm-12 col-lg-12" style="font-family: tahoma ;font-size: 9pt;">
		<div class="row">		
		<?=$gvProdukStockOpname?>
		</div>
	</div>
</div>