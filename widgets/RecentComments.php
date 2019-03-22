<?php

namespace artsoft\comment\widgets;

use artsoft\comment\models\search\CommentSearch;
use artsoft\comments\models\Comment;
use artsoft\models\User;
use artsoft\widgets\DashboardWidget;
use Yii;

class RecentComments extends DashboardWidget
{

    /**
     * Most recent comments limit
     */
    public $recentLimit = 5;
    
    public $layout = 'layout';
    public $commentTemplate = 'comment';

    public function run()
    {
        $recentComments = Comment::find()
                ->active()
                ->orderBy(['created_at' => SORT_DESC])
                ->limit($this->recentLimit)
                ->all();

        return $this->render($this->layout, [
            'recentComments' => $recentComments,
            'commentTemplate' => $this->commentTemplate,
        ]);
    }

}
