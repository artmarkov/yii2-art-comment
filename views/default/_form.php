<?php

use artsoft\comments\models\Comment;
use artsoft\helpers\Html;
use artsoft\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model artsoft\comments\models\Comment */
/* @var $form artsoft\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'comment-form',
        'validateOnBlur' => false,
    ])
    ?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <div class="form-group clearfix">
                <label class="control-label" style="float: left; padding-right: 5px;">
                    <?= $model->attributeLabels()['username'] ?> :
                </label>
                <span><?= $model->author ?></span>
            </div>

            <div class="form-group clearfix">
                <label class="control-label" style="float: left; padding-right: 5px;">
                    <?= $model->attributeLabels()['email'] ?> :
                </label>
                <span><?= ($model->email) ? $model->email : Yii::t('yii', '(not set)') ?></span>
            </div>

            <div class="form-group clearfix">
                <label class="control-label" style="float: left; padding-right: 5px;">
                    <?= $model->attributeLabels()['user_ip'] ?> :
                </label>
                <span><?= $model->user_ip ?></span>
            </div>

            <div class="form-group clearfix">
                <label class="control-label" style="float: left; padding-right: 5px;">
                    <?= $model->attributeLabels()['model'] ?> :
                </label>
                <span><?= $model->model ?></span>
            </div>

            <div class="form-group clearfix">
                <label class="control-label" style="float: left; padding-right: 5px;">
                    <?= $model->attributeLabels()['parent_id'] ?> :
                </label>
                <span><?= $model->parent_id ?></span>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">

                    <?= $form->field($model, 'status')->dropDownList(Comment::getStatusList()) ?>

                    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

                </div>

            </div>
        </div>
        <div class="panel-footer">
            <div class="form-group">
                <?= Html::a(Yii::t('art', 'Go to list'), ['/comment/default/index'], ['class' => 'btn btn-default']) ?>
                <?= Html::submitButton(Yii::t('art', 'Save'), ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('art', 'Delete'), ['/comment/default/delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ])
                ?>
            </div>
            <?= \artsoft\widgets\InfoModel::widget(['model' => $model]); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
