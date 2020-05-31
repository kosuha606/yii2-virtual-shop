<?php

namespace app\virtualModels\Domains\Multilang;


use kosuha606\VirtualModelHelppack\ServiceManager;

trait MultilangTrait
{
    /** @var LanguageService */
    private static $langService;

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function langAttribute($name)
    {
        if (!self::$langService) {
            self::$langService = ServiceManager::getInstance()->get(LanguageService::class);
        }
        $lang = self::$langService->getLang();

        if ($lang->is_default) {
            return $this->$name;
        }

        $modelClass = self::class;
        $translation = TranslationVm::one([
            'where' => [
                ['=', 'entity_id', $this->id],
                ['=', 'entity_class', $modelClass],
                ['=', 'attribute', $name]
            ]
        ]);

        if ($translation && $translation->data) {
            return $translation->data;
        }

        return $this->$name;
    }
}