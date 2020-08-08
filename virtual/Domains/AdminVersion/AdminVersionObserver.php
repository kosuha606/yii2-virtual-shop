<?php

namespace app\virtual\Domains\AdminVersion;

use kosuha606\VirtualAdmin\Domains\User\UserService;
use kosuha606\VirtualAdmin\Form\SecondaryFormService;
use kosuha606\VirtualAdmin\Services\RequestService;
use kosuha606\VirtualAdmin\Services\SessionService;
use kosuha606\VirtualModelHelppack\ServiceManager;

class AdminVersionObserver
{
    const MAX_VERSIONS_COUNT = 3;

    /**
     * Если модель сохранена из админ панели, то создается
     * запись о версии, которую можно восстановить в будушем
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public function afterSave()
    {
        $request = ServiceManager::getInstance()->get(RequestService::class);
        $sessionService = ServiceManager::getInstance()->get(SessionService::class);
        $sessionConfigVm = $sessionService->get(SecondaryFormService::SESSION_KEY);
        $sessionData = $sessionConfigVm->value;
        $mainData = $request->request()->post;
        $user = ServiceManager::getInstance()->get(UserService::class)->current();

        if (!$user->id) {
            return;
        }

        if (
            empty($mainData['id'])
            || empty($sessionData['baseModelId'])
            || empty($sessionData['baseModelClass'])
        ) {
            return;
        }

        if ($mainData['id'] !== $sessionData['baseModelId']) {
            return;
        }

        /** @var AdminVersionVm[] $existed */
        $existed = AdminVersionVm::many(['where' => [['all']], 'orderBy' => ['created_at' => SORT_ASC]]);

        if (count($existed) >= self::MAX_VERSIONS_COUNT) {
            $existed[0]->delete();
        }

        $newAdminVersion = AdminVersionVm::create([
            'entity_id' => $sessionData['baseModelId'],
            'entity_class' => $sessionData['baseModelClass'],
            'form_data' => json_encode($mainData, JSON_UNESCAPED_UNICODE),
            'form_config' => json_encode($sessionData, JSON_UNESCAPED_UNICODE),
            'user_id' => $user->id,
        ]);

        $newAdminVersion->save();
    }
}