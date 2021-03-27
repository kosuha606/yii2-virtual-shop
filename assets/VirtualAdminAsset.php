<?php

namespace app\assets;

use yii\web\AssetBundle;

class VirtualAdminAsset extends AssetBundle
{
    /** @var string  */
    public $sourcePath = '@vendor/kosuha606/virtual-admin/src/_js/dist/';

    /** @var array|string[]  */
    public $css = [
        'admin.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css',
    ];

    /** @var array|string[]  */
    public $js = [
        'admin.js',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js',
    ];
}
