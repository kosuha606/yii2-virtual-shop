<?php

namespace app\virtualModels\Services;


use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\DeliveryVm;

class DeliveryService
{
    public function findDeliveryById($id)
    {
        $delivery = VirtualModelManager::getInstance()->getProvider()->one(DeliveryVm::class, [
            'where' => [
                ['=', 'id', $id]
            ]
        ]);

        return $delivery;
    }
}