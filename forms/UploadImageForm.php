<?php

namespace app\forms;

use yii\base\Model;

class UploadImageForm extends Model
{
    public ?string $file = null;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            ['file', 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'jpeg']],
        ];
    }
}
