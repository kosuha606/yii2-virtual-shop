<?php

namespace app\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadImageForm extends Model
{
    public ?UploadedFile $file = null;

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
