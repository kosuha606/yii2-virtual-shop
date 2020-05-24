<?php

namespace app\forms;

use yii\base\Model;

class CkeditorForm extends Model
{
    public $upload;

    public function rules()
    {
        return [
            ['upload', 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'jpeg']],
        ];
    }
}
