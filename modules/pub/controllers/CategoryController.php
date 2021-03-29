<?php

namespace app\modules\pub\controllers;

use kosuha606\VirtualAdmin\Domains\Seo\SeoFilterService;
use kosuha606\VirtualAdmin\Domains\User\UserService;
use kosuha606\VirtualShop\Cart\CartBuilder;
use kosuha606\VirtualShop\Model\CategoryVm;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;

class CategoryController extends Controller
{
    private CartBuilder $cartBuilder;
    private UserService $userService;
    private Session $session;
    private SeoFilterService $seoFilterService;

    /**
     * @param $id
     * @param $module
     * @param CartBuilder $cartBuilder
     * @param UserService $userService
     * @param SeoFilterService $seoFilterService
     * @param Session $session
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        CartBuilder $cartBuilder,
        UserService $userService,
        SeoFilterService $seoFilterService,
        Session $session,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->cartBuilder = $cartBuilder;
        $this->userService = $userService;
        $this->session = $session;
        $this->seoFilterService = $seoFilterService;
    }

    /**
     * @return string
     */
    public function actionCategory(): string
    {
        $id = $this->request->get('id');
        $category = CategoryVm::one([
            'where' => [
                ['=', 'id', $id],
            ],
        ]);

        return $this->render('view', [
            'category' => $category,
        ]);
    }

    /**
     * @return Response
     */
    public function actionFilter(): Response
    {
        $filters = $this->request->post('filter', []);
        $seoFilterService = $this->seoFilterService;
        $url = $seoFilterService->createUrl($filters);
        $referer = $this->request->referrer;

        if ($url) {
            $referer = rtrim($referer, '/');
            $refererParts = explode('/filter-', $referer);

            return $this->redirect($refererParts[0].'/filter-'.$url);
        }

        return $this->redirect($referer.'?'.http_build_query([
            'filter' => $filters
        ]));
    }
}
