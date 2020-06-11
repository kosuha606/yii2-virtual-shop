<?php

namespace app\virtualModels\Admin\Test;

use app\virtualModels\Admin\Domains\Transaction\TransactionVm;
use kosuha606\VirtualModel\VirtualModelProvider;
use yii\db\Transaction;

class TestTransactionProvider extends VirtualModelProvider
{
    /** @var Transaction */
    private static $transation;

    public function type()
    {
        return TransactionVm::KEY;
    }

    public function environemnt(): string
    {
        return TransactionVm::KEY;
    }

    protected function findOne($modelClass, $config)
    {
        return null;
    }

    protected function findMany($modelClass, $config)
    {
        return null;
    }

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\NotSupportedException
     * @throws \yii\db\Exception
     */
    public static function begin()
    {
        // nothing to do
    }

    /**
     * @throws \yii\db\Exception
     */
    public static function commit()
    {
        // nothing to do
    }

    /**
     *
     */
    public static function rollback()
    {
        // nothing to do
    }
}

