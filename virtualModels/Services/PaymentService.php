<?php

namespace app\virtualModels\Services;

use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\PaymentVm;

class PaymentService
{
    /**
     * @param $id
     * @return PaymentVm
     * @throws \Exception
     */
    public function findPaymentById($id)
    {
        $payment = PaymentVm::one([
            'where' => [
                ['=', 'id', $id]
            ]
        ]);

        return $payment;
    }
}