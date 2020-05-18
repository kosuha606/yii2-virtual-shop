<?php

namespace app\virtualModels\Admin\Test;

use app\virtualModels\Admin\Interfaces\AdminControllerInterface;

class TestController implements AdminControllerInterface
{
    public function renderView($view, $args)
    {
        extract($args);
        ob_implicit_flush(true);
        ob_start();
        require __DIR__.'/views/'.$view.'.php';
        $content = ob_get_clean();

        return $content;
    }
}