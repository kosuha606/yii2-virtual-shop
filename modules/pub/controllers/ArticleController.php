<?php

namespace app\modules\pub\controllers;

use kosuha606\VirtualContent\Domains\Article\Models\ArticleVm;
use yii\web\Controller;
use yii\web\HttpException;

class ArticleController extends Controller
{
    /**
     * @return string
     */
    public function actionList(): string
    {
        $articles = ArticleVm::many([
            'where' => ['all'],
            'orderBy' => ['created_at' => SORT_DESC]
        ]);

        return $this->render('list', [
            'articles' => $articles
        ]);
    }

    /**
     * @return string
     */
    public function actionDetail(): string
    {
        $id = $this->request->get('id');
        $slug = $this->request->get('slug');
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