<?php

namespace app\urlRules;

use kosuha606\VirtualAdmin\Domains\Seo\SeoFilterService;
use kosuha606\VirtualAdmin\Domains\Seo\SeoService;
use kosuha606\VirtualContent\Domains\Article\Models\ArticleVm;
use kosuha606\VirtualContent\Domains\Page\Models\PageVm;
use kosuha606\VirtualShop\Model\CategoryVm;
use kosuha606\VirtualShop\Model\ProductVm;
use yii\base\BaseObject;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;

class SeoUrlRule extends BaseObject implements UrlRuleInterface
{
    private SeoService $seoService;
    private SeoFilterService $seoFilterService;

    /**
     * @param SeoService $seoService
     * @param SeoFilterService $seoFilterService
     * @param array $config
     */
    public function __construct(
        SeoService $seoService,
        SeoFilterService $seoFilterService,
        $config = []
    ) {
        parent::__construct($config);
        $this->seoService = $seoService;
        $this->seoFilterService = $seoFilterService;
    }

    /**
     * @param UrlManager $manager
     * @param Request $request
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = '/'.$request->pathInfo;
        $pathParts = explode('filter-', $pathInfo);
        $pathInfo = $pathParts[0];
        $pathInfo = rtrim($pathInfo, '/');

        $seoService = $this->seoService;
        $seoFilterService = $this->seoFilterService;

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

    /**
     * @param UrlManager $manager
     * @param string $route
     * @param array $params
     * @return false
     */
    public function createUrl($manager, $route, $params): bool
    {
        return false;
    }
}
