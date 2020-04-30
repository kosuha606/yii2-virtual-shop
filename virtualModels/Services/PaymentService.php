<?php

namespace app\virtualModels\Services;

use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\PaymentVm;

class PaymentService
{
    public function findPaymentById($id)
    {
        $payment = VirtualModelManager::getInstance()->getProvider()->one(PaymentVm::class, [
            'where' => [
                ['all']
            ]
        ]);

        return $payment;
    }
}