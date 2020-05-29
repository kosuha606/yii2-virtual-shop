<?php

use app\models\Cache;
use app\models\Comment;
use app\models\Text;
use yii\db\Migration;

class m200428_201759_x3_cache extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Cache::tableName(), [
            'id' => $this->primaryKey(),

            'entity_id' => $this->integer(11),
            'entity_class' => $this->string(255),
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
        $this->dropTable(Cache::tableName());
    }

}
