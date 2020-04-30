<?php

namespace app\controllers;

use kosuha606\VirtualModel\VirtualModel;
use yii\web\Controller;
use Yii;

class AdminController extends Controller
{
    /** @var CrudController */
    private $crud;

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