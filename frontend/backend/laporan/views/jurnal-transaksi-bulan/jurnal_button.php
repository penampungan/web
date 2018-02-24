<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\base\DynamicModel;

/**
* ===============================
 * Button & Link 
 * Author	: ptr.novgmail.com
 * Update	: 05/09/2017
 * Version	: 2.1
 * ===============================
*/
	
	/*
	 * BUTTON Akun Kategori
	*/
	function tombolViewGroup(){
		$title= Yii::t('app','Kategori Akun');
		$url = Url::toRoute(['/laporan/jurnal-transaksi-bulan/view-kategori']);
		$options1 = ['value'=>$url,
					'id'=>'jurnal-button-group',
					'data-pjax' => false,
					'class'=>"btn btn-success btn-xs",
					'title'=>'Tambah'
		];
		$content = Html::button($title,$options1);
		return $content;		
	}
	/*
	 * BUTTON Akun List
	*/
	function tombolViewAkun(){
		$title= Yii::t('app','List Akun');
		$url = Url::toRoute(['/laporan/jurnal-transaksi-bulan/view-akun']);
		$options1 = ['value'=>$url,
					'id'=>'jurnal-button-akun',
					'data-pjax' => false,
					'class'=>"btn btn-success btn-xs",
					'title'=>'Tambah'
		];
		$content = Html::button($title,$options1);
		return $content;		
	}
    
?>