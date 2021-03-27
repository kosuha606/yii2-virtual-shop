<?php

namespace app\widgets;

use kosuha606\VirtualAdmin\Domains\Menu\MenuVm;
use yii\base\Widget;

class MenuWidget extends Widget
{
    public string $code;

    /**
     * @return string
     */
    public function run(): string
    {
        $menu = MenuVm::one([
            'where' => [['=', 'code', $this->code]],
        ]);

        return $this->render('menu', [
            'menu' => $menu
        ]);
    }
}