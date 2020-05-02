<?php

use app\models\Action;
use app\models\Delivery;
use app\models\Order;
use app\models\OrderReserve;
use app\models\Payment;
use app\models\Product;
use app\models\ProductRests;
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
        $this->createTable(User::tableName(), [
            'id' => $this->primaryKey(),
            'username' => $this->string(255),
            'email' => $this->string(255),
            'password' => $this->string(255),
            'authKey' => $this->string(255),
            'accessToekn' => $this->string(255),
        ]);

        $this->createTable(Action::tableName(), [
            'id' => $this->primaryKey(),
            'productIds' => $this->string(255),
            'percent' => $this->integer(11),
            'userType' => $this->string(255),
        ]);

        $this->createTable(Delivery::tableName(), [
            'id' => $this->primaryKey(),
            'price' => $this->integer(11),
            'description' => $this->string(255),
            'userType' => $this->string(255),
        ]);

        $this->createTable(Order::tableName(), [
            'id' => $this->primaryKey(),
            'items' => $this->text(),
            'userType' => $this->string(255),
            'reserve' => $this->text(),
        ]);

        $this->createTable(OrderReserve::tableName(), [
            'id' => $this->primaryKey(),
            'orderId' => $this->integer(11),
            'productId' => $this->integer(11),
            'qty' => $this->integer(11),
            'userType' => $this->string(255),
        ]);

        $this->createTable(Payment::tableName(), [
            'id' => $this->primaryKey(),
            'comission' => $this->integer(11),
            'description' => $this->string(255),
            'userType' => $this->string(255),
        ]);

        $this->createTable(Product::tableName(), [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'price' => $this->integer(11),
            'price2B' => $this->integer(11),
            'actions' => $this->text(),
            'rests' => $this->text(),
        ]);

        $this->createTable(ProductRests::tableName(), [
            'id' => $this->primaryKey(),
            'productId' => $this->integer(11),
            'qty' => $this->integer(11),
            'userType' => $this->string(255),
        ]);

        $this->createTable(Promocode::tableName(), [
            'id' => $this->primaryKey(),
            'amount' => $this->integer(11),
            'code' => $this->string(255),
            'userType' => $this->string(255),
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
    }

}
