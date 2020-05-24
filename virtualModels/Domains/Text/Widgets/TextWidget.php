<?php

namespace app\virtualModels\Domains\Text\Widgets;

use app\virtualModels\Domains\Text\Models\TextVm;
use yii\base\Widget;

class TextWidget extends Widget
{
    public $code;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function run()
    {
        $text = TextVm::one([
            'where' => [['=', 'code', $this->code]]
        ]);

        return $this->render('text', [
            'text' => $text
        ]);
    }
}