<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
$this->params['breadcrumbs'][] = $title;
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <?php if(isset($message) && $message!=''){ ?>
                    <div class="alert alert-success">
                        <strong><?= $message?></strong>
                    </div>
                <?php } ?>
                <h2><?= Html::encode($title) ?></h2>
                <?php  $form = ActiveForm::begin([
                        'id' => 'add-form',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-2 control-label'],
                        ],
                ]); ?>
                    <?= $form->field($model, 'userId')->dropDownList($users) ?>
                    <?= $form->field($model, 'amount')->textInput() ?>
                    <?= $form->field($model, 'interest')->textInput() ?>
                    <?= $form->field($model, 'duration')->textInput() ?>
                    <?= $form->field($model, 'dateApplied')->widget(\yii\jui\DatePicker::classname(), [
							'language' => 'en',
							'dateFormat' => 'yyyy-MM-dd',
						]);
					?>
                    <?= $form->field($model, 'dateLoanEnds')->widget(\yii\jui\DatePicker::classname(), [
							'language' => 'en',
							'dateFormat' => 'yyyy-MM-dd',
						]);
					?>
                    <?= $form->field($model, 'campaign')->textInput() ?>
                    <?= $form->field($model, 'status')->dropDownList(['1' => '1', '2' => '2', '3' => '3']); ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
                    <?= Html::a('Cancel', ['/loan/list'], ['class'=>'btn btn-primary']) ?>
                <?php ActiveForm::end();  ?>
            </div>
        </div>
    </div>
</div>
