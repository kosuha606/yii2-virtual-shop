<?php

use app\models\Category;
use app\models\Comment;
use app\models\Product;
use app\models\SeoFilter;
use app\models\SeoPage;
use app\models\SeoRedirect;
use app\models\SeoUrl;
use app\models\StaticTranslation;
use yii\db\Migration;

class m200428_201759_x8_seo_filter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(SeoFilter::tableName(), [
            'id' => $this->primaryKey(),

            'value' => $this->string(255),
            'type' => $this->string(255),
            'slug' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(SeoFilter::tableName());
    }

}
