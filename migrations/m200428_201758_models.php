<?php

use app\models\Action;
use app\models\Delivery;
use app\models\Favorite;
use app\models\FilterCategory;
use app\models\FilterProduct;
use app\models\Menu;
use app\models\MenuItem;
use app\models\Order;
use app\models\OrderReserve;
use app\models\Payment;
use app\models\Product;
use app\models\ProductRests;
use app\models\ProductSeo;
use app\models\Promocode;
use app\models\User;
use yii\db\Migration;

/**
 * Class m200428_201758_models
 */
class m200428_201758_models extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(FilterProduct::tableName(), [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(11),
            'product_id' => $this->integer(11),
            'value' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(FilterCategory::tableName(), [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(User::tableName(), [
            'id' => $this->primaryKey(),
            'username' => $this->string(255),
            'email' => $this->string(255),
            'password' => $this->string(255),
            'authKey' => $this->string(255),
            'accessToekn' => $this->string(255),
            'personalDiscount' => $this->integer(2),
        ]);

        $this->createTable(Favorite::tableName(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'product_id' => $this->integer(11),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(Action::tableName(), [
            'id' => $this->primaryKey(),
            'productIds' => $this->string(255),
            'percent' => $this->integer(11),
            'userType' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(Delivery::tableName(), [
            'id' => $this->primaryKey(),
            'price' => $this->integer(11),
            'description' => $this->string(255),
            'userType' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(Order::tableName(), [
            'id' => $this->primaryKey(),
            'orderData' => $this->text(),
            'total' => $this->string(255),
            'user_id' => $this->integer(11)->null(),
            'userType' => $this->string(255),
            'reserve' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(OrderReserve::tableName(), [
            'id' => $this->primaryKey(),
            'orderId' => $this->integer(11),
            'productId' => $this->integer(11),
            'qty' => $this->integer(11),
            'userType' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(Payment::tableName(), [
            'id' => $this->primaryKey(),
            'comission' => $this->integer(11),
            'description' => $this->string(255),
            'userType' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(Product::tableName(), [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'price' => $this->integer(11),
            'price2B' => $this->integer(11),
            'actions' => $this->text(),
            'rests' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(ProductRests::tableName(), [
            'id' => $this->primaryKey(),
            'productId' => $this->integer(11),
            'qty' => $this->integer(11),
            'userType' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(Promocode::tableName(), [
            'id' => $this->primaryKey(),
            'amount' => $this->integer(11),
            'code' => $this->string(255),
            'userType' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(ProductSeo::tableName(), [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(11),
            'meta_title' => $this->string(255),
            'meta_keywords' => $this->string(255),
            'meta_description' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(Menu::tableName(), [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'code' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createTable(MenuItem::tableName(), [
            'id' => $this->primaryKey(),
            'link' => $this->string(255),
            'label' => $this->string(255),
            'menu_id' => $this->integer(11),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Action::tableName());
        $this->dropTable(Delivery::tableName());
        $this->dropTable(Order::tableName());
        $this->dropTable(OrderReserve::tableName());
        $this->dropTable(Payment::tableName());
        $this->dropTable(Product::tableName());
        $this->dropTable(ProductRests::tableName());
        $this->dropTable(Promocode::tableName());
        $this->dropTable(ProductSeo::tableName());
        $this->dropTable(Menu::tableName());
        $this->dropTable(MenuItem::tableName());
    }

}
