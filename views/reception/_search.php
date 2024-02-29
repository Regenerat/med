<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReceptionSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reception-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'patient_fio') ?>

    <?= $form->field($model, 'date_of_reception') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
