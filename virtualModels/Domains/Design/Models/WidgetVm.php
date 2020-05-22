<?php

namespace app\virtualModels\Domains\Design\Models;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $name
 * @property $widget_class
 *
 */
class WidgetVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'name',
            'widget_class',
        ];
    }

}