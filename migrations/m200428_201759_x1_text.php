<?php

use app\models\Text;
use yii\db\Migration;

class m200428_201759_x1_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Text::tableName(), [
            'id' => $this->primaryKey(),

            'description' => $this->string(255),
            'code' => $this->string(255),
            'content' => $this->text(),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Text::tableName());
    }
}
