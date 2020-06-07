<?php

namespace app\virtualProviders;

use app\virtualModels\Admin\Domains\Settings\SettingsProviderInterface;
use app\virtualModels\Admin\Domains\Settings\SettingsVm;
use kosuha606\VirtualModel\VirtualModelProvider;

class SettingsProvider extends VirtualModelProvider implements SettingsProviderInterface
{
    private $settingsPath = '@runtime/settings.json';

    public function type()
    {
        return SettingsVm::KEY;
    }

    public function getDefaultSettings()
    {
        $data = require_once __DIR__.'/../config/default_settings.php';

        return $data;
    }

    public function getSettings()
    {
        $settingsPath = \Yii::getAlias($this->settingsPath);

        if (!is_file($settingsPath)) {
            return [];
        }

        $dataJson = file_get_contents($settingsPath);
        $data = json_decode($dataJson, true);

        return $data;
    }

    public function saveSettings($settings)
    {
        $settingsPath = \Yii::getAlias($this->settingsPath);
        $settingsJson = json_encode($settings, JSON_UNESCAPED_UNICODE);

        file_put_contents($settingsPath, $settingsJson);
    }

    public function environemnt(): string
    {
        // TODO: Implement environemnt() method.
    }

    protected function findOne($modelClass, $config)
    {
        // TODO: Implement findOne() method.
    }

    protected function findMany($modelClass, $config)
    {
        // TODO: Implement findMany() method.
    }

}