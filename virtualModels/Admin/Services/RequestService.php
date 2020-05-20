<?php

namespace app\virtualModels\Admin\Services;

use app\virtualModels\Admin\Model\Request;

class RequestService
{
    /** @var Request */
    public static $request;

    public function clearRequest()
    {
        self::$request = null;
    }

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