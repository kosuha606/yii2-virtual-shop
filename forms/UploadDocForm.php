<?php

namespace app\forms;


use yii\base\Model;

class UploadDocForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            ['file', 'file', 'skipOnEmpty' => false, 'extensions' => ['pdf', 'doc', 'xls']],
        ];
    }
}
