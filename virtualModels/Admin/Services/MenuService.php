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

        // Сортируем меню
        foreach ($plainMenu as &$menuItem) {
            if (empty($menuItem['children'])) {
                continue;
            }

            uasort($menuItem['children'], function ($a, $b) {
                if (!isset($a['sort'])) {
                    $a['sort'] = 1;
                }

                if (!isset($b['sort'])) {
                    $b['sort'] = 1;
                }

                if ($a['sort'] === $b['sort']) {
                    return 0;
                }

                return $a['sort'] > $b['sort'] ? 1 : -1;
            });
        }

        uasort($plainMenu, function ($a, $b) {
            if (!isset($a['sort'])) {
                $a['sort'] = 1;
            }

            if (!isset($b['sort'])) {
                $b['sort'] = 1;
            }

            if ($a['sort'] === $b['sort']) {
                return 0;
            }

            return $a['sort'] > $b['sort'] ? 1 : -1;
        });

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