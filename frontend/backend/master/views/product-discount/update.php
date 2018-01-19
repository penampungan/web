<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\backend\master\models\ProductDiscount */

$this->title = 'Update Product Discount: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Product Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID, 'PRODUCT_ID' => $model->PRODUCT_ID, 'YEAR_AT' => $model->YEAR_AT, 'MONTH_AT' => $model->MONTH_AT]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-discount-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
