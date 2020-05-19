<?php

namespace app\virtualModels\Admin\Services;

use app\virtualModels\Admin\Model\Request;

class RequestService
{
    /** @var Request */
    private static $request;

    /**
     * @return Request
     * @throws \Exception
     */
    public function request(): Request
    {
        if (!self::$request) {
            self::$request = Request::one(['where' => [['all']]]);
        }

        return self::$request;
    }
}