<?php

namespace app\virtualModels\Services;

use app\models\User;
use app\virtualModels\Model\FavoriteVm;
use app\virtualModels\Model\ProductVm;
use app\virtualModels\Model\UserVm;

class FavoriteService
{
    /**
     * @param UserVm $user
     * @param ProductVm $product
     * @return bool
     * @throws \Exception
     */
    public function hasFavorite(UserVm $user, ProductVm $product)
    {
        $favorite = FavoriteVm::one([
            'where' => [
                ['=', 'user_id', $user->id],
                ['=', 'product_id', $product->id],
            ]
        ]);

        return !is_null($favorite->id);
    }

    /**
     * @param UserVm $user
     * @param ProductVm $product
     * @return bool
     * @throws \Exception
     */
    public function addUserProduct(UserVm $user, ProductVm $product)
    {
        if ($this->hasFavorite($user, $product)) {
            return false;
        }

        $favorite = FavoriteVm::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $favorite->save();
    }

    /**
     * @param $productId
     * @param $userId
     * @throws \Exception
     */
    public function deleteByProductAndUserId($productId, $userId)
    {
        $favorite = FavoriteVm::one([
            'where' => [
                'user_id' => $userId,
                'product_id' => $productId
            ]
        ]);

        if ($favorite->id) {
            $favorite->delete();
        }
    }
}