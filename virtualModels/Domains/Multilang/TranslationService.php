<?php

namespace app\virtualModels\Domains\Multilang;

use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ServiceManager;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    public $enableAutoTranslate = true;

    public $sourceLang = 'ru';

    public $autoTranslateLimit = 10;

    public $autoTranslateRequestsCount = 0;

    public function translate($value)
    {
        try {
            $staticTranslation = StaticTranslationVm::one([
                'where' => [
                    ['=', 'value', $value]
                ]
            ]);

            if (!$staticTranslation->id) {
                $staticTranslation = StaticTranslationVm::create([
                    'value' => $value
                ]);
                $ids = $staticTranslation->save();
                $staticTranslation->id = $ids[0];
            }

            $result = $staticTranslation->langAttribute('value');
        } catch (\Exception $exception) {
            $result = '';
        }

        return $result;
    }

    /**
     * @param VirtualModel $model
     * @param $field
     * @param LangVm $langVm
     * @return string|null
     * @throws \ErrorException
     */
    public function autoTranslate(VirtualModel $model, $field, LangVm $langVm)
    {
        if ($this->autoTranslateRequestsCount >= $this->autoTranslateLimit) {
            return '';
        }

        $tr = new GoogleTranslate();
        $tr->setSource($this->sourceLang);
        $tr->setTarget($langVm->code);
        $translated = $tr->translate($model->$field);
        $this->autoTranslateRequestsCount++;

        TranslationVm::create([
            'entity_id' => $model->id,
            'entity_class' => get_class($model),
            'lang_id' => $langVm->id,
            'attribute' => $field,
            'data' => $translated,
        ])->save();

        return $translated;
    }

}