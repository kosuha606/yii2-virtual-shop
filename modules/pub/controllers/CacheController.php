<?php

namespace app\modules\pub\controllers;

use yii\web\Controller;

class CacheController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
