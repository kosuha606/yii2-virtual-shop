<?php

namespace app\virtualModels\Admin\Domains\Settings;

use kosuha606\VirtualModel\VirtualModelManager;

class SettingsService
{
    /** @var SettingsProviderInterface */
    private $provider;

    private $defaultSettings = [];

    private $settings = [];

    public function __construct()
    {
        $this->provider = VirtualModelManager::getInstance()->getProvider(SettingsVm::KEY);

        if (!$this->provider instanceof SettingsProviderInterface) {
            throw new \Exception('settings provider must implement SettingProviderInterface');
        }
    }

    /**
     * Получить все настройки
     */
    public function getSettings()
    {

    }

    /**
     * Сохранить настройки
     */
    public function saveSettings()
    {

    }

    /**
     * Получить одно значение
     * @param $category
     * @param $field
     */
    public function setting($category, $field)
    {

    }
}