<?php

namespace app\widgets;

use yii\base\Widget;

class FooterWidget extends Widget
{
    public array $menus = [];

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('footer', [
            'menus' => $this->menus,
        ]);
    }
}
