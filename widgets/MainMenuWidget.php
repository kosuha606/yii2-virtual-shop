<?php

namespace app\widgets;

use kosuha606\VirtualAdmin\Domains\Multilang\LanguageService;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\base\Widget;

class MainMenuWidget extends Widget
{
    public function run()
    {
        $languages = ServiceManager::getInstance()->get(LanguageService::class)->getLanguages();

        return $this->render('main_menu', [
            'languages' => $languages,
        ]);
    }
}