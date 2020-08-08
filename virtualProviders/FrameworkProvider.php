<?php

namespace app\virtualProviders;

use app\models\User;
use app\virtual\Domains\Framework\FrameworkProviderInterface;
use kosuha606\VirtualAdmin\Domains\User\UserService;
use kosuha606\VirtualModel\VirtualModelProvider;
use kosuha606\VirtualModelHelppack\ServiceManager;
use Yii;

class FrameworkProvider extends VirtualModelProvider implements FrameworkProviderInterface
{
    public function type()
    {
        return FrameworkProviderInterface::class;
    }

    /**
     * @param $modelClass
     * @param $jsCode
     */
    public function registerJs($modelClass, $jsCode)
    {
        Yii::$app->controller->getView()->registerJs($jsCode);
    }

    /**
     * @param $modelClass
     * @param $data
     * @return bool
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public function login($modelClass, $data)
    {
        $user = false;

        if ($data['method'] === 'by_user_id') {
            $user = User::findOne($data['data']);
        }

        if ($data['method'] === 'by_email') {
            $user = User::findByEmail($data['data']);
        }

        if ($user) {
            $result = Yii::$app->user->login($user, 3600*24*30);

            if ($result) {
                ServiceManager::getInstance()->get(UserService::class)->login(Yii::$app->user->id);
            }
        }

        return $result;
    }

    /**
     * Проверка пароля
     *
     * @param $modelClass
     * @param $password
     * @param $hash
     * @return bool
     */
    public function checkPassword($modelClass, $password, $hash)
    {
        if (!$hash && !$password) {
            return true;
        }

        if (!$hash) {
            return false;
        }

        return Yii::$app->security->validatePassword($password, $hash);
    }

    public function getParam($modelClass, $name)
    {
        return Yii::$app->params[$name];
    }
}