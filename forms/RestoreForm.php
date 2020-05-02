<?php

namespace app\forms;

use yii\base\Model;

class RestoreForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            [
                'email',
                'required',
            ]
        ];
    }
}