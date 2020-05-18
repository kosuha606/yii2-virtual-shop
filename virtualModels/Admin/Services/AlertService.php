<?php

namespace app\virtualModels\Admin\Services;

use app\virtualModels\Admin\Model\Alert;

class AlertService
{
    /**
     * @return Alert[]
     * @throws \Exception
     */
    public function getAll()
    {
        return Alert::many(['where' => [['all']]]);
    }

    /**
     * @param $message
     * @throws \Exception
     */
    public function success($message)
    {
        Alert::create([
            'type' => 'success',
            'message' => $message
        ])->save();
    }

    public function error($message)
    {
        Alert::create([
            'type' => 'error',
            'message' => $message
        ])->save();
    }
}