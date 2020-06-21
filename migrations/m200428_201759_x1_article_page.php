<?php

use app\models\Article;
use app\models\Design;
use app\models\DesignWidget;
use app\models\MenuItem;
use app\models\Page;
use app\models\ProductSeo;
use app\models\SeoArticle;
use app\models\SeoPage;
use app\models\Widget;
use yii\db\Migration;

class m200428_201759_x1_article_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Article::tableName(), [
            'id' => $this->primaryKey(),

            'title' => $this->string(255),
            'slug' => $this->string(255),
            'content' => $this->text(),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(SeoArticle::tableName(), [
            'id' => $this->primaryKey(),

            'article_id' => $this->integer(11),
            'meta_title' => $this->string(255),
            'meta_keywords' => $this->string(255),
            'meta_description' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(Page::tableName(), [
            'id' => $this->primaryKey(),

            'title' => $this->string(255),
            'slug' => $this->string(255),
            'content' => $this->text(),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(SeoPage::tableName(), [
            'id' => $this->primaryKey(),

            'page_id' => $this->integer(11),
            'meta_title' => $this->string(255),
            'meta_keywords' => $this->string(255),
            'meta_description' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Article::tableName());
        $this->dropTable(SeoArticle::tableName());
        $this->dropTable(Page::tableName());
        $this->dropTable(SeoPage::tableName());
    }

}
