<?php

use app\models\SeoPage;
use app\models\SeoRedirect;
use app\models\SeoUrl;
use app\models\StaticTranslation;
use yii\db\Migration;

class m200428_201759_x6_seo_page_url extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(SeoPage::tableName(), 'url', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(SeoPage::tableName(), 'url');
    }

}
