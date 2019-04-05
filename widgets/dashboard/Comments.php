<?php

namespace artsoft\comment\widgets\dashboard;

use artsoft\comment\models\search\CommentSearch;
use artsoft\comments\models\Comment;
use artsoft\models\User;
use artsoft\widgets\DashboardWidget;
use Yii;

class Comments extends DashboardWidget
{
    /**
     * Most recent comments limit
     */
    public $recentLimit = 5;

    /**
     * Comment index action
     */
    public $commentIndexAction = 'comment/default/index';

    /**
     * Total comments options
     *
     * @var array
     */
    public $options;

    public function run()
    {
        if (!$this->options) {
            $this->options = $this->getDefaultOptions();
        }

        if (User::hasPermission('viewComments')) {
            $searchModel = new CommentSearch();
            $formName = $searchModel->formName();

            $recentComments = Comment::find()->active()->orderBy(['id' => SORT_DESC])->limit($this->recentLimit)->all();

            foreach ($this->options as &$option) {
                $count = Comment::find()->filterWhere($option['filterWhere'])->count();
                $option['count'] = $count;
                $option['url'] = [$this->commentIndexAction, $formName => $option['filterWhere']];
            }

            return $this->render('comments', [
                'comments' => $this->options,
                'recentComments' => $recentComments,
            ]);
        }
    }

    public function getDefaultOptions()
    {
        return [
            ['label' => Yii::t('art', 'Approved'), 'icon' => 'ok', 'filterWhere' => ['status' => Comment::STATUS_APPROVED]],
            ['label' => Yii::t('art', 'Pending'), 'icon' => 'search', 'filterWhere' => ['status' => Comment::STATUS_PENDING]],
            ['label' => Yii::t('art', 'Spam'), 'icon' => 'ban-circle', 'filterWhere' => ['status' => Comment::STATUS_SPAM]],
            ['label' => Yii::t('art', 'Trash'), 'icon' => 'trash', 'filterWhere' => ['status' => Comment::STATUS_TRASH]],
        ];
    }
}