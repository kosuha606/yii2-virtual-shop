<?php

namespace app\forms;

use yii\base\Model;

class UploadImageForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            ['file', 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'jpeg']],
        ];
    }
}
