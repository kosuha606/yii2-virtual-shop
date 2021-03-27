<?php

namespace app\forms;

use yii\base\Model;

class CkeditorForm extends Model
{
    public string $upload;

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
