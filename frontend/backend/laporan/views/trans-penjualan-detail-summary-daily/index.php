<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\backend\laporan\models\TransPenjualanDetailSummaryDailySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trans Penjualan Detail Summary Dailies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trans-penjualan-detail-summary-daily-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Trans Penjualan Detail Summary Daily', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'ACCESS_GROUP',
            'STORE_ID',
            'TAHUN',
            'BULAN',
            // 'TGL',
            // 'PRODUCT_ID',
            // 'PRODUCT_NM',
            // 'PRODUCT_PROVIDER',
            // 'PRODUCT_PROVIDER_NO',
            // 'PRODUCT_PROVIDER_NM',
            // 'PRODUCT_QTY',
            // 'HPP',
            // 'HARGA_JUAL',
            // 'SUB_TOTAL',
            // 'CREATE_AT',
            // 'UPDATE_AT',
            // 'KETERANGAN:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
