<?php

use app\models\AdminVersion;
use app\models\SeoFilter;
use yii\db\Migration;

class m200428_201759_xx10_admin_version extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(AdminVersion::tableName(), [
            'id' => $this->primaryKey(),

            'user_id' => $this->integer(11),
            'entity_id' => $this->string(255),
            'entity_class' => $this->string(255),
            'form_data' => $this->text(),
            'form_config' => $this->text(),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(AdminVersion::tableName());
    }

}
