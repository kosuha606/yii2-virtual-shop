<?php

namespace app\urlRules;

use app\virtualModels\Admin\Domains\Seo\SeoFilterService;
use app\virtualModels\Admin\Domains\Seo\SeoService;
use app\virtualModels\Domains\Article\Models\ArticleVm;
use app\virtualModels\Domains\Page\Models\PageVm;
use app\virtualModels\Model\CategoryVm;
use app\virtualModels\Model\ProductVm;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\base\BaseObject;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;

class SeoUrlRule extends BaseObject implements UrlRuleInterface
{
    /**
     * @param UrlManager $manager
     * @param Request $request
     * @return array|bool
     * @throws \Exception
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = '/'.$request->pathInfo;
        $pathParts = explode('filter-', $pathInfo);
        $pathInfo = $pathParts[0];
        $pathInfo = rtrim($pathInfo, '/');

        /** @var SeoService $seoService */
        $seoService = ServiceManager::getInstance()->get(SeoService::class);
        $seoFilterService = ServiceManager::getInstance()->get(SeoFilterService::class);

        if ($pathInfo === '' && isset($pathParts[1])) {
            $filter = [];
            if (isset($pathParts[1])) {
                $filter = $seoFilterService->parseUrl($pathParts[1]);
            }

            return ['/pub/site/index', ['filter' => $filter]];
        }

        if ($model = $seoService->findModelByUrl($pathInfo)) {
            if ($model instanceof CategoryVm) {
                $filter = [];
                if (isset($pathParts[1])) {
                    $filter = $seoFilterService->parseUrl($pathParts[1]);
                }

                return ['/pub/category/category', ['id' => $model->id, 'filter' => $filter]];
            }

            if ($model instanceof ProductVm) {
                return ['/pub/site/view',[ 'id' => $model->id ]];
            }

            if ($model instanceof ArticleVm) {
                return ['/pub/article/detail',[ 'id' => $model->id, 'slug' => $model->slug ]];
            }

            if ($model instanceof PageVm) {
                return ['/pub/page/detail',[ 'id' => $model->id, 'slug' => $model->slug ]];
            }
        }

        return false;
    }

    public function createUrl($manager, $route, $params)
    {
        return false;
    }
}