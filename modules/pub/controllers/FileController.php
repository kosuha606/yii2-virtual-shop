<?php

namespace app\modules\pub\controllers;

use app\forms\CkeditorForm;
use app\forms\UploadDocForm;
use app\forms\UploadImageForm;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

// FIXME поправить дублирование
class FileController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @return Response
     */
    public function actionCkeditor(): Response
    {
        $model = new CkeditorForm();

        $userId = Yii::$app->user->identity->getId() ?: 'guest';
        $attrName = 'upload';
        $result = [
            'uploaded' => true,
        ];

        if (Yii::$app->request->isPost) {
            $model->{$attrName} = UploadedFile::getInstanceByName($attrName);

            if ($model->validate()) {
                $saveDirectory = 'uploads/docs/'.$userId;

                if (!is_dir($saveDirectory)) {
                    FileHelper::createDirectory($saveDirectory, $mode = 0775, $recursive = true);
                }

                $filePath = $saveDirectory.'/'.$model->{$attrName}->baseName.'_'.time().'.'.$model->{$attrName}->extension;

                $model->{$attrName}->saveAs($filePath);

                $result['url'] = '/'.$filePath;
            } else {
                $result['uploaded'] = false;
                $result['error']['message'] = $model->getErrorSummary(true);
            }
        }

        return $this->asJson($result);
    }

    /**
     * @return Response
     */
    public function actionUploadDocument(): Response
    {
        $model = new UploadDocForm();

        return $this->commonUploadOneFile($model);
    }

    /**
     * @return Response
     */
    public function actionUploadImage(): Response
    {
        $model = new UploadImageForm();

        return $this->commonUploadOneFile($model);
    }

    /**
     * @param $model
     * @return Response
     */
    private function commonUploadOneFile(Model $model, $attrName = 'file'): Response
    {
        $userId = Yii::$app->user->identity->getId() ?: 'guest';
        $result = [
            'result' => true,
        ];

        if (Yii::$app->request->isPost) {
            $model->{$attrName} = UploadedFile::getInstanceByName($attrName);

            if ($model->validate()) {
                $saveDirectory = 'uploads/docs/'.$userId;

                if (!is_dir($saveDirectory)) {
                    FileHelper::createDirectory($saveDirectory, $mode = 0775, $recursive = true);
                }

                $filePath = $saveDirectory.'/'.$model->{$attrName}->baseName.'_'.time().'.'.$model->{$attrName}->extension;

                $model->{$attrName}->saveAs($filePath);

                $result['file'] = $filePath;
            } else {
                $result['result'] = false;
                $result['error'] = $model->getErrorSummary(true);
            }
        }

        return $this->asJson($result);
    }

    /**
     * @return Response
     */
    public function actionDelete(): Response
    {
        return $this->asJson([
            'result' => true,
        ]);
    }
}
