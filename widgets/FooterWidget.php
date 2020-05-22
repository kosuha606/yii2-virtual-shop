<?php

namespace app\widgets;

use yii\base\Widget;

class FooterWidget extends Widget
{
    public $menus = [];

    public function run()
    {
        return $this->render('footer', [
            'menus' => $this->menus,
        ]);
    }
}