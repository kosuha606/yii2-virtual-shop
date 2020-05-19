<?php

namespace app\virtualModels\Admin\Form;

use kosuha606\VirtualModel\VirtualModel;

/**
 * Строитель, отвечающий за построение второстепенной формы сущности
 */
class SecondaryFormBuilder
{
    private $masterMmodel;

    private $relationType;

    private $tabName = 'Tab';

    private $initialConfig;
    /**
     * @var SecondaryFormService
     */
    private $formService;

    public function __construct(
        SecondaryFormService $formService
    ) {
        $this->formService = $formService;
    }

    /**
     * @return VirtualModel
     */
    public function getMasterModel()
    {
        return $this->masterMmodel;
    }

    /**
     * @param VirtualModel $model
     * @return SecondaryFormBuilder
     */
    public function setMasterModel($model)
    {
        $this->masterMmodel = $model;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelationType()
    {
        return $this->relationType;
    }

    /**
     * @param mixed $relationType
     * @return SecondaryFormBuilder
     */
    public function setRelationType($relationType)
    {
        $this->relationType = $relationType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTabName()
    {
        return $this->tabName;
    }

    /**
     * @param string $tabName
     * @return SecondaryFormBuilder
     */
    public function setTabName($tabName)
    {
        $this->tabName = $tabName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInitialConfig()
    {
        return $this->initialConfig;
    }

    /**
     * @param mixed $initialConfig
     * @return SecondaryFormBuilder
     */
    public function setInitialConfig($initialConfig)
    {
        $this->initialConfig = $initialConfig;

        return $this;
    }

    public function getConfig()
    {
        $this->formService->rememberForm($this);
    }
}