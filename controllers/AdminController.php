<?php

namespace app\controllers;

use app\virtualModels\Controllers\CrudController;
use app\virtualModels\ServiceManager;
use kosuha606\VirtualModel\VirtualModel;
use yii\web\Controller;
use Yii;

class AdminController extends Controller
{
    /** @var CrudController */
    private $crud;

    public function beforeAction($action)
    {
        ServiceManager::getInstance()->userService->login(Yii::$app->user->id);

        return parent::beforeAction($action);
    }

    public function init()
    {
        $this->crud = new CrudController();
        parent::init();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionList()
    {
        $modelClass = Yii::$app->request->get('model');
        $list = $this->crud->actionList($modelClass, [['all']]);

        return $this->render('list', $list);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionDetail()
    {
        $id = Yii::$app->request->get('id');
        /** @var VirtualModel $modelClass */
        $modelClass = Yii::$app->request->get('model');

        $item = $modelClass::create();

        if ($id) {
            $item = $this->crud->actionView($id);
        }

        if (Yii::$app->request->isPost) {
            if ($id) {
                $item = $this->crud->actionEdit($modelClass, Yii::$app->request->post(), $id);
            } else {
                $item = $this->crud->actionEdit($modelClass, Yii::$app->request->post());
            }
        }

        return $this->render('detail', $item);
    }
}