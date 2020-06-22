<?php

namespace app\widgets;

use kosuha606\VirtualContent\Domains\Text\Models\TextVm;
use yii\base\Widget;use function Symfony\Component\String\u;

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