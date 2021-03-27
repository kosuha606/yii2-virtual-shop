<?php

namespace app\widgets;

use kosuha606\VirtualContent\Domains\Text\Models\TextVm;
use yii\base\Widget;

class TextWidget extends Widget
{
    public string $code;

    /**
     * @return string
     */
    public function run(): string
    {
        $text = TextVm::one([
            'where' => [['=', 'code', $this->code]]
        ]);

        return $this->render('text', [
            'text' => $text
        ]);
    }
}
