<?php

namespace app\virtualModels\Domains\Multilang;

use app\virtualModels\Admin\Model\Session;
use app\virtualModels\Admin\Services\SessionService;

class LanguageService
{
    const SESSION_KEY = 'language';

    /**
     * @var SessionService
     */
    private $sessionService;

    private static $langs;

    public function __construct(
        SessionService $sessionService
    ) {
        $this->sessionService = $sessionService;
        self::$langs = LangVm::many(['where' => [['all']]], 'code');
    }

    /**
     * @return LangVm
     * @throws \Exception
     */
    public function getLang()
    {
        /** @var Session $lang */
        $lang = $this->sessionService->get(self::SESSION_KEY);

        if ($lang) {
            $lang = $lang->value;
        }

        if (!$lang) {
            $lang = 'ru';
        }

        $langInst = LangVm::one(['where' => [
            ['=', 'code', $lang]
        ]]);

        return $langInst;
    }

    /**
     * @param $code
     * @throws \Exception
     */
    public function setLang($code)
    {
        $this->sessionService->save(self::SESSION_KEY, $code);
    }

    /**
     * @return LangVm[]
     */
    public function getLanguages()
    {
        return self::$langs;
    }
}