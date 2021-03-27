<?php

namespace app\forms;

use yii\base\Model;

class UploadDocForm extends Model
{
    public ?string $file = null;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            ['file', 'file', 'skipOnEmpty' => false, 'extensions' => ['pdf', 'doc', 'xls']],
        ];
    }
}
