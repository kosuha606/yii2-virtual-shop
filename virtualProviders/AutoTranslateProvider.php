<?php

namespace app\virtualProviders;

use kosuha606\VirtualAdmin\Domains\Multilang\AutoTranslatorProviderInterface;
use kosuha606\VirtualModel\Example\MemoryModelProvider;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AutoTranslateProvider extends MemoryModelProvider implements AutoTranslatorProviderInterface
{
    public function type()
    {
        return AutoTranslatorProviderInterface::class;
    }

    /**
     * @param $fromLang
     * @param $toLang
     * @param $string
     * @return string|null
     * @throws \ErrorException
     */
    public function autoTranslate($fromLang, $toLang, $string)
    {
        if (!$toLang) {
            return $string;
        }

        $tr = new GoogleTranslate();
        $tr->setSource($fromLang);
        $tr->setTarget($toLang);
        $translated = $tr->translate($string);

        return $translated;
    }
}