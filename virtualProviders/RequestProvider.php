<?php

namespace app\virtualProviders;

use app\virtualModels\Admin\Model\Request;
use kosuha606\VirtualModel\Example\MemoryModelProvider;
use Yii;

class RequestProvider extends MemoryModelProvider
{
    public function type()
    {
        return Request::TYPE;
    }

    public function __construct()
    {
        $realRequest = Yii::$app->request;

        $this->memoryStorage = [
            Request::class => [
                [
                    'get' => $realRequest->get(),
                    'post' => $realRequest->post(),
                    'isAjax' => $realRequest->isAjax,
                    'isPost' => $realRequest->isPost,
                ]
            ]
        ];
    }
}