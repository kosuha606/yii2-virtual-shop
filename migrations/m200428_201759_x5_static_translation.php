<?php

use app\models\SeoPage;
use app\models\SeoRedirect;
use app\models\SeoUrl;
use app\models\StaticTranslation;
use yii\db\Migration;

class m200428_201759_x5_static_translation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(StaticTranslation::tableName(), [
            'id' => $this->primaryKey(),

            'value' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(StaticTranslation::tableName());
    }

}
