<?php

use app\models\Comment;
use yii\db\Migration;

class m200428_201759_x2_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Comment::tableName(), [
            'id' => $this->primaryKey(),

            'user_id' => $this->integer(11),
            'model_id' => $this->integer(11),
            'model_class' => $this->string(255),
            'content' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Comment::tableName());
    }
}
