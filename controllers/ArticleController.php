<?php

namespace app\controllers;

use app\virtualModels\Domains\Article\Models\ArticleVm;
use app\virtualModels\Domains\Page\Models\PageVm;
use yii\web\Controller;
use yii\web\HttpException;

class ArticleController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
    public function actionList()
    {
        $articles = ArticleVm::many(['where' => ['all']]);

        return $this->render('list', [
            'articles' => $articles
        ]);
    }

    /**
     * @return string
     * @throws HttpException
     * @throws \Exception
     */
    public function actionDetail()
    {
        $id = \Yii::$app->request->get('id');
        $slug = \Yii::$app->request->get('slug');
        $article = ArticleVm::one(['where' => [
            ['=', 'id', $id],
            ['=', 'slug', $slug]
        ]]);

        if (!$article->id) {
            throw new HttpException(404);
        }

        return $this->render('detail', [
            'article' => $article
        ]);
    }
}