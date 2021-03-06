<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\backend\transaksi\models\PenjualanDetail */

$this->title = 'Update Penjualan Detail: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="penjualan-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
