<?php

namespace app\virtualModels\Admin\Services;

class MenuService
{
    private $menu;

    public function processConfig($config)
    {
        $plainMenu = $config['menu'];

        foreach ($config['routes'] as $controller) {
            foreach ($controller as $action) {
                if (!isset($action['menu'])) {
                    continue;
                }

                if (!isset($action['menu']['parent'])) {
                    $plainMenu[$action['menu']['name']] = $action['menu'];
                    continue;
                }

                if (isset($plainMenu[$action['menu']['parent']])) {
                    $plainMenu[$action['menu']['parent']]['children'][] = $action['menu'];
                }
            }
        }

        $this->menu = $plainMenu;
    }

    /**
     * @return mixed
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @param mixed $menu
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
    }
}