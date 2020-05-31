<?php

namespace app\virtualModels\Domains\Multilang;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $id
 * @property $entity_id
 * @property $entity_class
 * @property $lang_id
 * @property $attribute
 * @property $data
 *
 */
class TranslationVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'entity_id',
            'entity_class',
            'lang_id',
            'attribute',
            'data',
        ];
    }
}