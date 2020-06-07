<?php

namespace app\virtualModels\Admin\Domains\Settings;

interface SettingsProviderInterface
{
    public function getDefaultSettings();

    public function getSettings();

    public function saveSettings($settings);
}