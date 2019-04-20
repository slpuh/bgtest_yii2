<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Переводы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Преводы можно осуществлять только между зарегистрированными пользователями:</p>
    <?php Pjax::begin(); ?>   
    <h4>Ваш текущий баланс: <?= $balance ?></h4>

    <div class="row">
        <div class="col-lg-5">
        
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model->user, 'username')->textInput(['autofocus' => true, 'placeholder' => 'username'])->label('Получатель') ?>

                <?= $form->field($model, 'amount')->textInput(['autofocus' => true, 'placeholder' => 'e.g. 25.00'])->label('Сумма') ?>                 

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'trensfer-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>