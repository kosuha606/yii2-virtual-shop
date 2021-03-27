<?php

namespace app\widgets;

use kosuha606\VirtualAdmin\Domains\Multilang\LanguageService;
use yii\base\Widget;

class MainMenuWidget extends Widget
{
    private LanguageService $languageService;

    /**
     * @param LanguageService $languageService
     * @param array $config
     */
    public function __construct(LanguageService $languageService, $config = [])
    {
        parent::__construct($config);
        $this->languageService = $languageService;
    }

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('main_menu', [
            'languages' => $this->languageService->getLanguages(),
        ]);
    }
}
