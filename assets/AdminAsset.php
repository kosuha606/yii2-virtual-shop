<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = __DIR__.'/resources/admin';

    public $js = [
        'script.js',
    ];

    public $css = [
        'style.css',
    ];
}