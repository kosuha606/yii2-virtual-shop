<?php

namespace app\virtualModels\Admin\Form;

use app\virtualModels\Admin\Services\RequestService;
use app\virtualModels\Admin\Services\SessionService;
use kosuha606\VirtualModel\VirtualModel;

/**
 * Сервис отвечающий за работу с второстепенными формами сущности
 */
class SecondaryFormService
{
    const SESSION_KEY = 'secondary_form';

    private $isSessionCleared = false;

    private $formTypeCounter = 0;

    /**
     * @var SessionService
     */
    private $sessionService;
    /**
     * @var RequestService
     */
    private $requestService;

    public function __construct(
        SessionService $sessionService,
        RequestService $requestService
    ) {
        $this->sessionService = $sessionService;
        $this->requestService = $requestService;
    }

    /**
     * Построить форму
     * @return SecondaryFormBuilder
     * @throws \Exception
     */
    public function buildForm(): SecondaryFormBuilder
    {
        if (
            !$this->isSessionCleared
            && !$this->requestService->request()->isPost
        ) {
            $this->clearSession();
        }

        return new SecondaryFormBuilder($this);
    }

    /**
     * Запомнить форму
     * @param SecondaryFormBuilder $builder
     * @throws \Exception
     */
    public function rememberForm(SecondaryFormBuilder $builder)
    {
        $formSession = $this->sessionService->get(self::SESSION_KEY);

        $value = [];
        if ($formSession->value) {
            $value = $formSession->value;
        }

        $value[$builder->getRelationClass()] = [
            'masterModelId' => $builder->getMasterModel()->id,
            'masterModelField' => $builder->getMasterModelField(),
            'masterModelClass' => get_class($builder->getMasterModel()),
            'relationType' => $builder->getRelationType(),
        ];

        $this->sessionService->save(self::SESSION_KEY, $value);
    }

    /**
     * Выполнить обработку запомненных форм
     * @throws \Exception
     */
    public function processRememberedForm()
    {
        if (!$this->requestService->request()->isPost) {
            return;
        }

        $postData = $this->requestService->request()->post;
        $sessionConfig = $this->sessionService->get(self::SESSION_KEY);

        if (!isset($postData[self::SESSION_KEY])) {
            // Если нет данных пищем пустой массив
            $postData[self::SESSION_KEY] = [];
            foreach ($sessionConfig->value as $sessClass => $data) {
                $postData[self::SESSION_KEY][$sessClass] = [];
            }
        }

        $modelClasses = array_keys($postData[self::SESSION_KEY]);

        // Удаляем все связанные старые модели
        /** @var VirtualModel $class */
        foreach ($modelClasses as $class) {
            $sessionModelData = $sessionConfig->value[$class];
            $models = $class::many(['where' => [['=', $sessionModelData['masterModelField'], $sessionModelData['masterModelId']]]]);
            /** @var VirtualModel $model */
            foreach ($models as $model) {
                $model->delete();
            }
        }

        /**
         * Создаем новые связанные модели
         * @var VirtualModel $modelClass
         * @var  $data
         */
        foreach ($postData[self::SESSION_KEY] as $modelClass => $data) {
            foreach ($data as $attributes) {
                $modelClass::create($attributes)->save();
            }
        }
    }

    /**
     * @return int
     */
    public function getFormTypeCounter(): int
    {
        $this->formTypeCounter++;

        return $this->formTypeCounter;
    }

    /**
     * @param int $formTypeCounter
     */
    public function setFormTypeCounter(int $formTypeCounter)
    {
        $this->formTypeCounter = $formTypeCounter;
    }

    /**
     * @throws \Exception
     */
    private function clearSession()
    {
        $this->isSessionCleared = true;
        $this->sessionService->remove(self::SESSION_KEY);
    }
}