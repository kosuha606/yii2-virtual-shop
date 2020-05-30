<?php

namespace app\virtualModels\Admin\Structures;

class DetailComponents
{
    const INPUT_FIELD = 'InputField';

    const HTML_FIELD = 'HtmlField';

    const HIDDEN_FIELD = 'HiddenField';

    const TEXTAREA_FIELD = 'TextField';

    const SELECT_FIELD = 'SelectField';

    const CHECKBOX_FIELD = 'CheckboxField';

    const REDACTOR_FIELD = 'RedactorField';

    const IMAGE_FIELD = 'ImageField';

    const CONFIG_BUILDER_FIELD = 'ConfigBuilderField';

    public static function MULTILANG_FIELD($field, $label, $value)
    {
        return [
            'field' => $field,
            'label' => $label,
            'component' => 'MultilangField',
            'value' => $value,
        ];
    }
}
