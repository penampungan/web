<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Store;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model frontend\backend\master\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'STORE_ID',[					
					'addon' => [
						'prepend' => [
							'content'=>'<span >STORE</span>',
							'options'=>['style' =>' background-color: lightblue;text-align:right']
						]
					]
				])->widget(Select2::classname(),[
            'data'=>ArrayHelper::map(Store::find()->where(['ACCESS_GROUP'=>Yii::$app->user->identity->ACCESS_GROUP,'STATUS'=>['1','0']])->all(),'STORE_ID','STORE_NM'),'language' => 'en',
            'options' => ['placeholder'=>'Select Category....'],
            'pluginOptions' => [
                'allowClear' => true
            ], 
        ])->label('STORE')->label(false)?>

    <?= $form->field($model, 'NAME',[					
					'addon' => [
						'prepend' => [
							'content'=>'<span >NAMA</span>',
							'options'=>['style' =>' background-color: lightblue;text-align:right']
						]
					]
				])->textInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'EMAIL',[					
					'addon' => [
						'prepend' => [
							'content'=>'<span >EMAIL</span>',
							'options'=>['style' =>' background-color: lightblue;text-align:right']
						]
					]
				])->widget(MaskedInput::classname(),['clientOptions' => [
        'alias' =>  'email'
    ]])->label(false) ?>

    <?= $form->field($model, 'PHONE',[					
					'addon' => [
						'prepend' => [
							'content'=>'<span >PHONE</span>',
							'options'=>['style' =>' background-color: lightblue;text-align:right']
						]
					]
				])->widget(MaskedInput::classname(),
        ['mask' => '(999) 9999999'])->label('Phone')->label(false) ?>

    <?= $form->field($model, 'DCRP_DETIL')->textarea(['rows' => 6]) ?>

    <div class="form-group text-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
