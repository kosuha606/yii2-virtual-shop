<?php

use app\models\Cache;
use app\models\Comment;
use app\models\Lang;
use app\models\Product;
use app\models\SeoPage;
use app\models\SeoRedirect;
use app\models\SeoUrl;
use app\models\Text;
use app\models\Version;
use yii\db\Migration;

class m200428_201759_x5_product_slug extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Product::tableName(), 'slug', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Product::tableName(), 'slug');
    }

}
