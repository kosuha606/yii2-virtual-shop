<?php

namespace app\virtual\Domains\Framework;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @method static login($data);
 * @method static checkPassword($password, $hash);
 * @method static getParam($name);
 * @method static registerJs($jsCode);
 */
class FrameworkVm extends VirtualModelEntity
{
    public static function providerType()
    {
        return FrameworkProviderInterface::class;
    }
}