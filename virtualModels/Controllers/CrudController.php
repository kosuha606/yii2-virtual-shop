<?php

namespace app\virtualModels\Controllers;

use kosuha606\VirtualModel\VirtualModel;
use yii\web\Controller;

class CrudController
{
    /**
     * @param $modelClass
     * @param int $page
     * @param array $filter
     * @return array
     * @throws \Exception
     */
    public function actionList($modelClass, $filter = [], $page = 1, $itemPerPage = 999)
    {
        /** @var VirtualModel $modelClass */
        $offset = ($page-1)*$itemPerPage;

        $models = $modelClass::many([
            'where' => $filter,
            'limit' => $itemPerPage,
            'offset' => $offset,
        ]);

        return $models;
    }

    /**
     * @param $modelClass
     * @param $id
     * @return VirtualModel
     * @throws \Exception
     */
    public function actionView($modelClass, $id)
    {
        /** @var VirtualModel $modelClass */
        return $modelClass::one([
            'where' => [
                ['=', 'id', $id]
            ]
        ]);
    }

    /**
     * @param $modelClass
     * @param $data
     * @param null $id
     * @return |null
     * @throws \Exception
     */
    public function actionEdit($modelClass, $data, $id=null)
    {
        /** @var VirtualModel $modelClass */
        if ($id) {
            $model = $modelClass::one([
                'where' => [
                    ['=', 'id', $id]
                ]
            ]);
            foreach ($data as $field => $value) {
                $model->setAttribute($field, $value);
            }
        } else {
            $model = $modelClass::create($data);
        }

        return $model->save();
    }
}