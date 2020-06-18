<?php

use app\models\SeoFilter;
use yii\db\Migration;

class m200428_201759_x8_seo_filter_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(SeoFilter::tableName(), 'order', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(SeoFilter::tableName(), 'order');
    }

}
