<?php

namespace app\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class CkeditorForm extends Model
{
    public ?UploadedFile $upload = null;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            ['upload', 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'jpeg']],
        ];
    }
}
