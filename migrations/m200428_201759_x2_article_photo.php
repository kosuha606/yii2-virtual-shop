<?php

use app\models\Article;
use app\models\Comment;
use app\models\Text;
use yii\db\Migration;

class m200428_201759_x2_article_photo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Article::tableName(), 'photo', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Article::tableName(), 'photo');
    }

}
