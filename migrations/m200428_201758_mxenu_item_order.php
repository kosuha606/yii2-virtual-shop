<?php

use app\models\MenuItem;
use yii\db\Migration;

class m200428_201758_mxenu_item_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(MenuItem::tableName(), '`order`', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(MenuItem::tableName(), '`order`');
    }
}
