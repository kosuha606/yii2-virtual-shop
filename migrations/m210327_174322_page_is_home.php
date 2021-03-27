<?php

use app\models\Page;
use yii\db\Migration;

class m210327_174322_page_is_home extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Page::tableName(), 'is_home', $this->tinyInteger(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Page::tableName(), 'is_home');
    }
}
