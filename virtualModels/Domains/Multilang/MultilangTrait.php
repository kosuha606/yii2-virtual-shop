<?php

namespace app\virtualModels\Domains\Multilang;


use kosuha606\VirtualModelHelppack\ServiceManager;

trait MultilangTrait
{
    /** @var LanguageService */
    private static $langService;

    /** @var TranslationService */
    private static $tralnslationService;

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

        if (!self::$tralnslationService) {
            self::$tralnslationService = ServiceManager::getInstance()->get(TranslationService::class);
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
                ['=', 'attribute', $name],
                ['=', 'lang_id', $lang->id],
            ]
        ]);

        if ($translation && $translation->data) {
            return $translation->data;
        }

        if ($translation && self::$tralnslationService->enableAutoTranslate) {
            if (!$lang->is_default) {
                $result = self::$tralnslationService->autoTranslate($this, $name, $lang);
                return $result;
            }
        }

        return $this->$name;
    }
}