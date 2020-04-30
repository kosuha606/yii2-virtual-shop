<?php

namespace app\virtualModels\Services;

use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\PromocodeVm;

class PromocodeService
{
    /**
     * @param $id
     * @return PromocodeVm
     */
    public function findPromocodeById($id)
    {
        /** @var PromocodeVm $promocode */
        $promocode = VirtualModelManager::getInstance()->getProvider()->one(PromocodeVm::class, [
            'where' => [
                ['=', 'id', $id]
            ]
        ]);

        return $promocode;
    }
}