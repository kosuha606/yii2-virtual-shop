<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Подключаем js и css админки
 */
class VirtualAdminAsset extends AssetBundle
{
    public $sourcePath = '@vendor/kosuha606/virtual-admin/src/_js/dist/';

    public $css = [
        'admin.css',
    ];

    public $js = [
        'admin.js',
    ];
}