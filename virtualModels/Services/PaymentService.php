<?php

namespace app\virtualModels\Services;

use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\Payment;

class PaymentService
{
    public function findPaymentById($id)
    {
        $payment = VirtualModelManager::getInstance()->getProvider()->one(Payment::class, [
            'where' => [
                ['all']
            ]
        ]);

        return $payment;
    }
}