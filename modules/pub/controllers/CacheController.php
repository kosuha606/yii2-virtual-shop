<?php

namespace app\modules\pub\controllers;

use app\virtualModels\Domains\Cache\CacheService;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\web\Controller;

class CacheController extends Controller
{
    /**
     * @return string
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}