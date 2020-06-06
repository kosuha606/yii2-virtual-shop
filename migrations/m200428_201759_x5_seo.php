<?php

use app\models\Cache;
use app\models\Comment;
use app\models\Lang;
use app\models\SeoPage;
use app\models\SeoRedirect;
use app\models\SeoUrl;
use app\models\Text;
use app\models\Version;
use app\virtualModels\Admin\Domains\Seo\SeoUrlVm;
use yii\db\Migration;

class m200428_201759_x5_seo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(SeoUrl::tableName(), [
            'id' => $this->primaryKey(),

            'entity_id' => $this->integer(),
            'entity_class' => $this->string(255),
            'url' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(SeoRedirect::tableName(), [
            'id' => $this->primaryKey(),

            'from_url' => $this->string(255),
            'to_url' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->dropTable(SeoPage::tableName());
        $this->createTable(SeoPage::tableName(), [
            'id' => $this->primaryKey(),

            'entity_id' => $this->integer(11),
            'entity_class' => $this->string(255),
            'title' => $this->string(255),
            'meta_keywords' => $this->string(255),
            'mata_description' => $this->string(255),
            'og_title' => $this->string(255),
            'og_description' => $this->string(255),
            'og_url' => $this->string(255),
            'og_image' => $this->string(255),
            'og_type' => $this->string(255),
            'canonical' => $this->string(255),
            'noindex' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(SeoUrl::tableName());
        $this->dropTable(SeoRedirect::tableName());
        $this->dropTable(SeoPage::tableName());
    }

}
