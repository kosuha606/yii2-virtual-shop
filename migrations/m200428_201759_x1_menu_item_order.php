<?php

use app\models\Design;
use app\models\DesignWidget;
use app\models\MenuItem;
use app\models\ProductSeo;
use app\models\Widget;
use app\virtualModels\Domains\Menu\Models\DesignWidgetVm;
use yii\db\Migration;

class m200428_201759_x1_menu_item_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(MenuItem::tableName(), 'order', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(MenuItem::tableName(), 'order');
    }

}
