<?php

use app\models\Action;
use app\models\Delivery;
use app\models\Order;
use app\models\OrderReserve;
use app\models\Payment;
use app\models\Product;
use app\models\ProductRests;
use app\models\Promocode;
use yii\db\Migration;

/**
 * Class m200428_201758_models
 */
class m200428_201759_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(Action::tableName(), [
            'productId' => 1,
            'percent' => 10,
            'userType' => 'b2c',
        ]);
        $this->insert(Action::tableName(), [
            'productId' => 2,
            'percent' => 10,
            'userType' => 'b2c',
        ]);
        $this->insert(Delivery::tableName(), [
            'price' => 100,
            'description' => 'До двери',
            'userType' => 'b2c',
        ]);
        $this->insert(Delivery::tableName(), [
            'price' => 200,
            'description' => 'До ПВЗ',
            'userType' => 'b2c',
        ]);
        $this->insert(Payment::tableName(), [
            'comission' => 10,
            'description' => 'Яндекс.касса',
            'userType' => 'b2c',
        ]);
        $this->insert(Payment::tableName(), [
            'comission' => 20,
            'description' => 'Webmoney',
            'userType' => 'b2c',
        ]);

        $this->insert(Product::tableName(), [
            'name' => 'VirtualModel',
            'price' => '100',
            'price2B' => 50,
            'actions' => '',
            'rests' => '',
        ]);

        $this->insert(Product::tableName(), [
            'name' => 'Yii2Shop',
            'price' => '100',
            'price2B' => 50,
            'actions' => '',
            'rests' => '',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

}
