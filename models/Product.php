<?php

namespace app\models;



use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\Example\Shop\ServiceManager;
use kosuha606\VirtualModel\Example\Shop\Services\ProductService;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Inflector;

/**
 * Продукт
 */
class Product extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => new Expression('NOW()'),
            ],
        ];
    }

    public static function tableName()
    {
        return 'product';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'name',
                    'price',
                    'price2B',
                ],
                'required',
            ],
            [
                [
                    'slug',
                    'actions',
                    'rests',
                ],
                'safe'
            ]
        ];
    }

    public function beforeSave($insert)
    {
        $this->slug = Inflector::slug($this->name);
        return parent::beforeSave($insert);
    }
}