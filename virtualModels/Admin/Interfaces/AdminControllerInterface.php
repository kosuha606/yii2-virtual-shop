<?php

namespace app\virtualModels\Admin\Interfaces;

interface AdminControllerInterface
{
    public function renderView($view, $args);
}