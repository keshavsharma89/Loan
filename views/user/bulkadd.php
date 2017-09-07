<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
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
                <?php if(isset($errmsg) && $errmsg!=''){ ?>
                    <div class="alert alert-warning">
                        <strong><?= $errmsg?></strong>
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
                        'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
				<?= $form->field($model, 'jfile')->fileInput()->label('Add file') ?>
				<?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
				<?= Html::a('Cancel', ['/user/list'], ['class'=>'btn btn-primary']) ?>
				<?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
