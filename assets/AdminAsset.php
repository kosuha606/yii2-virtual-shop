<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    /** @var string  */
    public $sourcePath = __DIR__.'/resources/admin';

    /** @var array|string[]  */
    public $js = [
        'script.js',
    ];

    /** @var array|string[]  */
    public $css = [
        'style.css',
    ];
}
