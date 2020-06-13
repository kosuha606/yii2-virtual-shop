<?php

use app\models\Category;
use app\models\Comment;
use app\models\Product;
use app\models\SeoPage;
use app\models\SeoRedirect;
use app\models\SeoUrl;
use app\models\StaticTranslation;
use yii\db\Migration;

class m200428_201759_x7_products_adv extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Product::tableName(), 'photo', $this->string(255));
        $this->addColumn(Product::tableName(), 'category_id', $this->integer(11));
        $this->createTable(Category::tableName(), [
            'id' => $this->primaryKey(),

            'name' => $this->string(255),
            'slug' => $this->string(255),
            'photo' => $this->string(255),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Product::tableName(), 'photo');
        $this->dropColumn(Product::tableName(), 'category_id');
        $this->dropTable(Category::tableName());
    }

}
