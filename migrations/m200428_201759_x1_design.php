<?php

use app\models\Design;
use app\models\DesignWidget;
use app\models\MenuItem;
use app\models\ProductSeo;
use app\models\Widget;
use yii\db\Migration;

class m200428_201759_x1_design extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable(Design::tableName(), [
            'id' => $this->primaryKey(),

            'name' => $this->string(255),
            'route' => $this->string(255),
            'priority' => $this->integer(11),
            'template' => $this->text(),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(DesignWidget::tableName(), [
            'id' => $this->primaryKey(),

            'design_id' => $this->integer(11),
            'widget_id' => $this->integer(11),
            'position' => $this->string(255),
            'order' => $this->integer(11),
            'config' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(Widget::tableName(), [
            'id' => $this->primaryKey(),

            'name' => $this->string(255),
            'widget_class' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Design::tableName());
        $this->dropTable(DesignWidget::tableName());
        $this->dropTable(Widget::tableName());
    }

}
