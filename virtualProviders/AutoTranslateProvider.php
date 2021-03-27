<?php

namespace app\virtualProviders;

use kosuha606\VirtualAdmin\Domains\Multilang\AutoTranslatorProviderInterface;
use kosuha606\VirtualModel\Example\MemoryModelProvider;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AutoTranslateProvider extends MemoryModelProvider implements AutoTranslatorProviderInterface
{
    /**
     * @return string
     */
    public function type(): string
    {
        return AutoTranslatorProviderInterface::class;
    }

    /**
     * @param $fromLang
     * @param $toLang
     * @param $string
     * @return string|null
     */
    public function autoTranslate($fromLang, $toLang, $string): ?string
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
