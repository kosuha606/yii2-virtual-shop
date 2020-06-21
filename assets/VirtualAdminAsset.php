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
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css',
    ];

    public $js = [
        'admin.js',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js',
    ];
}