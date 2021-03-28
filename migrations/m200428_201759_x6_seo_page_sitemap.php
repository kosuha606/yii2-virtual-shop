<?php

use app\models\SeoPage;
use yii\db\Migration;

class m200428_201759_x6_seo_page_sitemap extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(SeoPage::tableName(), 'sitemap_importance', $this->string(255));
        $this->addColumn(SeoPage::tableName(), 'sitemap_freq', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(SeoPage::tableName(), 'sitemap_importance');
        $this->dropColumn(SeoPage::tableName(), 'sitemap_freq');
    }
}
