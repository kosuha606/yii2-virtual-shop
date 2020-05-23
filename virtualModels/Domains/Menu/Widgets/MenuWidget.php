<?php

namespace app\virtualModels\Domains\Menu\Widgets;

use app\virtualModels\Domains\Menu\Models\MenuVm;
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