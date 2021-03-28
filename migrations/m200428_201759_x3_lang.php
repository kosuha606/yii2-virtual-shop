<?php

use app\models\Lang;
use yii\db\Migration;

class m200428_201759_x3_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Lang::tableName(), [
            'id' => $this->primaryKey(),

            'code' => $this->string(255),
            'name' => $this->string(255),
            'is_default' => $this->boolean(),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Lang::tableName());
    }
}
