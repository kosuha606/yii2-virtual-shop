<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public string $basePath = '@webroot';
    public string $baseUrl = '@web';
    public array $css = [
        'css/site.css',
    ];
    public array $js = [;
    public array $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
