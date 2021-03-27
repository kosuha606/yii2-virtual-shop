<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    /** @var string  */
    public $basePath = '@webroot';

    /** @var string  */
    public $baseUrl = '@web';

    /** @var array|string[]  */
    public $css = [
        'css/site.css',
    ];

    /** @var array  */
    public $js = [];

    /** @var array|string[]  */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
