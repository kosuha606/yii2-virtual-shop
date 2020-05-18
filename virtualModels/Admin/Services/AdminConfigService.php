<?php

namespace app\virtualModels\Admin\Services;

use yii\helpers\ReplaceArrayValue;
use yii\helpers\UnsetArrayValue;

class AdminConfigService
{
    public static function merge($a, $b)
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            foreach (array_shift($args) as $k => $v) {
                if ($v instanceof UnsetArrayValue) {
                    unset($res[$k]);
                } elseif ($v instanceof ReplaceArrayValue) {
                    $res[$k] = $v->value;
                } elseif (is_int($k)) {
                    if (array_key_exists($k, $res)) {
                        $res[] = $v;
                    } else {
                        $res[$k] = $v;
                    }
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = static::merge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }

        return $res;
    }

    public function loadConfigs($dir)
    {
        $files = glob("$dir/*.php");
        $config = [];

        foreach ($files as $file) {
            $fileConfig = require($file);
            $config = self::merge($config, $fileConfig);
        }

        return $config;
    }
}