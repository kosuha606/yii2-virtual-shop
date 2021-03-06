<?php

use app\models\Translation;
use yii\db\Migration;

class m200428_201759_x3_translation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Translation::tableName(), [
            'id' => $this->primaryKey(),

            'entity_id' => $this->integer(11),
            'entity_class' => $this->string(255),
            'lang_id' => $this->integer(11),
            'attribute' => $this->string(255),
            'data' => $this->text(),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Translation::tableName());
    }
}
