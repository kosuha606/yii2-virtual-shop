<?php

namespace app\virtualProviders;

use kosuha606\VirtualAdmin\Domains\Transaction\TransactionVm;
use kosuha606\VirtualModel\VirtualModelProvider;
use yii\db\Transaction;

/**
 * Провайдер для транзакций для Yii2
 */
class TransactionProvider extends VirtualModelProvider
{
    /** @var Transaction[] */
    private static $transation = [];

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
    public static function begin($name = 'default')
    {
        if (!isset(self::$transation[$name])) {
            self::$transation[$name] = \Yii::$app->db->beginTransaction();
        }
    }

    /**
     * @throws \yii\db\Exception
     */
    public static function commit($name = 'default')
    {
        if (isset(self::$transation[$name])) {
            self::$transation[$name]->commit();
            self::$transation[$name] = null;
        }
    }

    /**
     *
     */
    public static function rollback($name = 'default')
    {
        if (isset(self::$transation[$name])) {
            self::$transation[$name]->rollBack();
            self::$transation[$name] = null;
        }
    }
}
