<?php

namespace app\virtualProviders;

use kosuha606\VirtualAdmin\Domains\Cookie\CookieProviderInterface;
use kosuha606\VirtualModel\VirtualModelProvider;
use Yii;

class CookieProvider extends VirtualModelProvider implements CookieProviderInterface
{
    /**
     * @return string
     */
    public function type(): string
    {
        return CookieProviderInterface::class;
    }

    public function get($modelClass, $key)
    {
        $result = Yii::$app->request->cookies->get($key);

        return $result->value ?? null;
    }

    public function getRaw($modelClass, $key)
    {
        return $_COOKIE[$key] ?? null;
    }

    public function set($modelClass, $key, $value, $expires = 3600)
    {
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => $key,
            'value' => $value,
            'expire' => $expires,
        ]));
    }
}