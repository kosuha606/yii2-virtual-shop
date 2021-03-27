<?php

namespace app\forms;

use yii\base\Model;

class RestoreForm extends Model
{
    public ?string $email = null;

    /**
     * @return \string[][]
     */
    public function rules(): array
    {
        return [
            [
                'email',
                'required',
            ]
        ];
    }
}
