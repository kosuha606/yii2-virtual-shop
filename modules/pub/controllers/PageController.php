<?php

namespace app\modules\pub\controllers;

use kosuha606\VirtualContent\Domains\Page\Models\PageVm;
use yii\web\Controller;
use yii\web\HttpException;

class PageController extends Controller
{
    /**
     * @return string
     * @throws HttpException
     * @throws \Exception
     */
    public function actionDetail()
    {
        $id = \Yii::$app->request->get('id');
        $slug = \Yii::$app->request->get('slug');
        $page = PageVm::one(['where' => [
            ['=', 'id', $id],
            ['=', 'slug', $slug]
        ]]);

        if (!$page->id) {
            throw new HttpException(404);
        }

        return $this->render('detail', [
            'page' => $page
        ]);
    }
}