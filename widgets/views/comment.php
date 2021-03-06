<?php

use artsoft\comments\assets\CommentsAsset;
use artsoft\comments\Comments;
use yii\helpers\Html;

/* @var $this yii\web\View */

$commentsAsset = CommentsAsset::register($this);
Comments::getInstance()->commentsAssetUrl = $commentsAsset->baseUrl;
?>

<div class="clearfix recent-comment">
    <div class="author text-center pull-left">
        <img class="avatar" src="<?= Comments::getInstance()->renderUserAvatar($comment->user_id) ?>"/>
        <div class="text-primary">
            <?= Html::encode($comment->getAuthor()); ?>
        </div>
    </div>
    <div>
        <div class="time text-right">
            <?= "{$comment->createdDate} {$comment->createdTime}" ?>
        </div>
        <div class="content text-justify">
            <?= $comment->shortContent ?>
            <?= Html::a(Yii::t('art', 'Read more...'), $comment->url) ?>
        </div>
    </div>
</div>
