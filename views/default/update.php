<?php

use artsoft\comments\Comments;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model artsoft\comments\models\Comment */

$this->title = Yii::t('art', 'Update "{item}"', ['item' => Comments::t('comments', 'Comment')]);
$this->params['breadcrumbs'][] = ['label' => Comments::t('comments', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('art', 'Update');
?>
<div class="comment-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>