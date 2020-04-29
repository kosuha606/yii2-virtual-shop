<?php

namespace app\virtualModels\Services;

use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\Promocode;

class PromocodeService
{
    /**
     * @param $id
     * @return Promocode
     */
    public function findPromocodeById($id)
    {
        /** @var Promocode $promocode */
        $promocode = VirtualModelManager::getInstance()->getProvider()->one(Promocode::class, [
            'where' => [
                ['=', 'id', $id]
            ]
        ]);

        return $promocode;
    }
}