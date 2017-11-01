<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\backend\hris\models\HrdAbsenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hrd Absens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hrd-absen-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Hrd Absen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'BULAN',
            // 'ACCESS_GROUP',
            // 'STORE_ID',
            'KARYAWAN_ID',
            'KARYAWAN',
            'TGL',
            'MASUK',
            'KELUAR',
            'LONGITUDE',
            'LATITUDE',
            // 'KARYAWAN_ID',
            // 'TGL',
            // 'WAKTU',
            // 'LATITUDE',
            // 'LONGITUDE',
            // 'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',
            // 'STATUS',
            // 'DCRP_DETIL:ntext',
            // 'YEAR_AT',
            // 'MONTH_AT',
// public $TAHUN;
	// public $BULAN;
	// public $ACCESS_GROUP;
	// public $STORE_ID;
	// public $KARYAWAN_ID;
	// public $KARYAWAN;
	// public $TGL;
	// public $MASUK;
	// public $KELUAR;
	// public $LONGITUDE;
	// public $LATITUDE;
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
