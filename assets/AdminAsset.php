<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public string $sourcePath = __DIR__.'/resources/admin';
    public array $js = [
        'script.js',
    ];
    public array $css = [
        'style.css',
    ];
}
