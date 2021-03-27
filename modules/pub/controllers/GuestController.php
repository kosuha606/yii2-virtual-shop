<?php

namespace app\modules\pub\controllers;

use app\forms\LoginForm;
use app\forms\RegistrationForm;
use app\forms\RestoreForm;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class GuestController extends Controller
{
    /**
     * @return string|Response
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->password = $model->password;
            $user->save();
            Yii::$app->session->addFlash('success', 'Вы успешно зарегистрированы');

            return $this->goBack();
        }

        return $this->render('registration', [
            'model' => $model
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionRestorePassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RestoreForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->goBack();
        }

        return $this->render('restore_password', [
            'model' => $model
        ]);
    }

    /**
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }
}
