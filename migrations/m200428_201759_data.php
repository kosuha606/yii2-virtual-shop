<?php

use app\models\Action;
use app\models\Delivery;
use app\models\FilterCategory;
use app\models\FilterProduct;
use app\models\Menu;
use app\models\MenuItem;
use app\models\Payment;
use app\models\Product;
use app\models\ProductRests;
use app\models\Promocode;
use app\models\User;
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
        $data = require_once __DIR__.'/data.php';


        $this->insert(FilterCategory::tableName(), [
            'id' => 1,
            'name' => 'Тип',
        ]);

        $this->insert(FilterCategory::tableName(), [
            'id' => 2,
            'name' => 'Цвет',
        ]);

        $this->insert(FilterCategory::tableName(), [
            'id' => 3,
            'name' => 'Размер',
        ]);

        $this->insert(Action::tableName(), [
            'productIds' => '[2, 3]',
            'percent' => 10,
            'userType' => 'b2c',
        ]);
        $this->insert(Action::tableName(), [
            'productIds' => '[4, 5]',
            'percent' => 20,
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

        foreach ($data['products'] as $product) {
            $filters = $product['filters'];
            unset($product['filters']);

            $this->insert(Product::tableName(), $product);

            $this->insert(ProductRests::tableName(), [
                'productId' => $product['id'],
                'qty' => 10,
                'userType' => 'b2c',
            ]);

            foreach ($filters as $filterCategoryId => $value) {
                $this->insert(FilterProduct::tableName(), [
                    'category_id' => $filterCategoryId,
                    'product_id' => $product['id'],
                    'value' => $value,
                ]);
            }
        }

        $this->insert(Promocode::tableName(), [
            'amount' => 100,
            'code' => 'demo',
            'userType' => 'b2c',
        ]);


        $user = new User();
        $user->password = 'admin';
        $user->username = 'admin';
        $user->email = 'admin@admin.com';
        $user->save();

        $menu = new Menu([
            'name' => 'Основное',
            'code' => 'main',
        ]);
        $menu->save();

        $menuItem = new MenuItem([
            'link' => '/one',
            'label' => 'Певый',
            'menu_id' => $menu->id,
        ]);
        $menuItem->save();

        $menuItem = new MenuItem([
            'link' => '/two',
            'label' => 'Второй',
            'menu_id' => $menu->id,
        ]);
        $menuItem->save();


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
