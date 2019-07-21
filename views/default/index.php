<?php

use artsoft\comments\Comments;
use artsoft\comments\models\Comment;
use artsoft\grid\GridPageSize;
use artsoft\grid\GridQuickLinks;
use artsoft\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel artsoft\comments\models\search\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Comments::t('comments', 'Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title"><?= Html::encode($this->title) ?></h3>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?php
                    echo GridQuickLinks::widget([
                        'model' => Comment::className(),
                        'searchModel' => $searchModel,
                        'options' => [
                            ['label' => Yii::t('art', 'Approved'), 'filterWhere' => ['status' => Comment::STATUS_APPROVED]],
                            ['label' => Yii::t('art', 'Pending'), 'filterWhere' => ['status' => Comment::STATUS_PENDING]],
                            ['label' => Yii::t('art', 'Spam'), 'filterWhere' => ['status' => Comment::STATUS_SPAM]],
                            ['label' => Yii::t('art', 'Trash'), 'filterWhere' => ['status' => Comment::STATUS_TRASH]],
                        ]
                    ])
                    ?>
                </div>

                <div class="col-sm-6 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'comment-grid-pjax']) ?>
                </div>
            </div>

            <?php
            Pjax::begin([
                'id' => 'comment-grid-pjax',
            ])
            ?>

            <?=
            GridView::widget([
                'id' => 'comment-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'comment-grid',
                    'actions' => [
                        Url::to(['bulk-activate']) => Comments::t('comments', 'Approve'),
                        Url::to(['bulk-deactivate']) => Comments::t('comments', 'Unapprove'),
                        Url::to(['bulk-spam']) => Comments::t('comments', 'Mark as Spam'),
                        Url::to(['bulk-trash']) => Comments::t('comments', 'Move to Trash'),
                        Url::to(['bulk-delete']) => Yii::t('art', 'Delete'),
                    ]
                ],
                'columns' => [
                    ['class' => 'artsoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'artsoft\grid\columns\TitleActionColumn',
                        'controller' => '/comment/default',
                        'attribute' => 'content',
                        'title' => function (Comment $model) {
                            return Html::a(mb_substr($model->content, 0, 32) . '...',
                                ['/comment/default/update', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                        'buttonsTemplate' => '{update} {delete}',
                    ],
                    [
                        'label' => Yii::t('art', 'User'),
                        'value' => function (Comment $model) {
                            return $model->getAuthor();
                        },
                        'options' => ['style' => 'width:150px'],
                    ],
                    [
                        'attribute' => 'model',
                        'value' => function (Comment $model) {
                            return $model->model . (($model->model_id) ? ' [' . $model->id . ']'
                                : '');
                        },
                        'options' => ['style' => 'width:250px'],
                    ],
                    // 'email:email',
                    // 'parent_id',
                   //  'super_parent_id',
                    [
                        'class' => 'artsoft\grid\columns\StatusColumn',
                        'attribute' => 'status',
                        'optionsArray' => Comment::getStatusOptionsList(),
                        'options' => ['style' => 'width:60px'],
                    ],
                    [
                        'class' => 'artsoft\grid\columns\DateFilterColumn',
                        'attribute' => 'created_at',
                        'value' => function (Comment $model) {
                            return '<span style="font-size:85%;" class="label label-'
                            . ((time() >= $model->created_at) ? 'primary' : 'default') . '">'
                            . $model->createdDate . ' ' . $model->createdTime . '</span>';
                        },
                        'format' => 'raw',
                        'options' => ['style' => 'width:150px'],
                    ],
                    [
                        'attribute' => 'user_ip',
                        'options' => ['style' => 'width:100px'],
                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


