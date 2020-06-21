<?php

namespace app\widgets;

use kosuha606\VirtualAdmin\Domains\Menu\MenuVm;
use yii\base\Widget;

class MenuWidget extends Widget
{
    public $code;

    public function run()
    {
        $menu = MenuVm::one([
            'where' => [['=', 'code', $this->code]],
        ]);

        return $this->render('menu', [
            'menu' => $menu
        ]);
    }
}