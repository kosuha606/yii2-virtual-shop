<?php

use app\models\Lang;
use app\models\Version;
use yii\db\Migration;

class m200428_201759_x4_version extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Version::tableName(), [
            'id' => $this->primaryKey(),

            'entity_id' => $this->integer(),
            'entity_class' => $this->string(255),
            'attributes' => $this->text(),

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
