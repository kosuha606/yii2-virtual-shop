<?php

namespace app\virtualModels\Services;


use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\Delivery;

class DeliveryService
{
    public function findDeliveryById($id)
    {
        $delivery = VirtualModelManager::getInstance()->getProvider()->one(Delivery::class, [
            'where' => [
                ['=', 'id', $id]
            ]
        ]);

        return $delivery;
    }
}