<?php

namespace app\virtualModels\Admin\Structures;

use app\virtualModels\Admin\Form\SecondaryFormBuilder;
use app\virtualModels\Admin\Form\SecondaryFormService;
use app\virtualModels\Domains\Multilang\LangVm;
use app\virtualModels\Domains\Multilang\TranslationVm;
use app\virtualModels\Model\OrderReserveVm;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ServiceManager;

class DetailComponents
{
    /** @var LangVm[] */
    private static $langs;

    private static $translationForms = [];

    const INPUT_FIELD = 'InputField';

    const HTML_FIELD = 'HtmlField';

    const HIDDEN_FIELD = 'HiddenField';

    const TEXTAREA_FIELD = 'TextField';

    const SELECT_FIELD = 'SelectField';

    const CHECKBOX_FIELD = 'CheckboxField';

    const REDACTOR_FIELD = 'RedactorField';

    const IMAGE_FIELD = 'ImageField';

    const CONFIG_BUILDER_FIELD = 'ConfigBuilderField';

    /**
     * @param $component
     * @param $field
     * @param $label
     * @param $value
     * @return array
     * @throws \Exception
     */
    public static function MULTILANG_FIELD(
        $component,
        $field,
        $label,
        $value,
        $model
    ) {
        if (!self::$langs) {
            self::$langs = VirtualModel::allToArray(LangVm::many(['where' => [['all']]]));
        }

        $modelClass = get_class($model);
        if (!isset(self::$translationForms[$modelClass])) {
            $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);
            $secondaryService->buildForm()
                ->setMasterModelId($model->id.','.get_class($model))
                ->setMasterModelField('entity_id,entity_class')
                ->setRelationClass(TranslationVm::class)
                ->setConfig(function ($model) {})
                ->getConfig()
            ;

            self::$translationForms[$modelClass] = true;
        }

        return [
            'field' => $field,
            'label' => $label,
            'component' => 'MultilangField',
            'value' => $value,
            'additionalValues' => [

            ],
            'props' => [
                'relationClass' => TranslationVm::class,
                'component' => $component,
                'langs' => self::$langs,
                'entity_id' => $model->id,
                'entity_class' => $modelClass,
            ]
        ];
    }
}
