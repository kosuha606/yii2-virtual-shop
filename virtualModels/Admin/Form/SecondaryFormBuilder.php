<?php

namespace app\virtualModels\Admin\Form;

use kosuha606\VirtualModel\VirtualModel;
use yii\helpers\Inflector;

/**
 * Строитель, отвечающий за построение второстепенной формы сущности
 */
class SecondaryFormBuilder
{
    const ONE_TO_ONE = 'one.to.one';

    const ONE_TO_MANY = 'one.to.many';

    private $id;

    private $masterMmodel;

    private $masterModelId;

    private $masterModelField;

    private $relationType;

    private $relationEntities = [];

    private $relationClass;

    private $tabName = 'Tab';

    private $config;
    /**
     * @var SecondaryFormService
     */
    private $formService;

    public function __construct(
        SecondaryFormService $formService
    ) {
        $this->formService = $formService;
        $this->id = $this->formService->getFormTypeCounter();
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
        return $this->config;
    }

    /**
     * @param mixed $initialConfig
     * @return SecondaryFormBuilder
     */
    public function setConfig($initialConfig)
    {
        $this->config = $initialConfig;

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getConfig()
    {
        $this->formService->rememberForm($this);
        $items = [];
        $initialConfig = $this->getInitialConfig();
        $relationClass = $this->getRelationClass();

        $initialConfigData = $initialConfig(new $relationClass());

        foreach ($this->getRelationEntities() as $entity) {
            $items[] = $initialConfig($entity);
        }

        if (
            $this->getRelationType() === self::ONE_TO_ONE &&
            count($items) === 0
        ) {
            $items[] = $initialConfigData;
        }

        return [
            'tab' => $this->getTabName(),
            'tabLink' => Inflector::slug($this->getTabName()),
            'type' => $this->getRelationType(),
            'initialConfig' => $initialConfigData,
            'relationClass' => $this->getRelationClass(),
            'dataConfig' => $items,
        ];
    }

    /**
     * @return array
     */
    public function getRelationEntities(): array
    {
        return $this->relationEntities;
    }

    /**
     * @param array $relationEntities
     */
    public function setRelationEntities(array $relationEntities)
    {
        $this->relationEntities = $relationEntities;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelationClass()
    {
        return $this->relationClass;
    }

    /**
     * @param mixed $relationClass
     * @return SecondaryFormBuilder
     */
    public function setRelationClass($relationClass)
    {
        $this->relationClass = $relationClass;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMasterModelField()
    {
        return $this->masterModelField;
    }

    /**
     * @param mixed $masterModelField
     * @return SecondaryFormBuilder
     */
    public function setMasterModelField($masterModelField)
    {
        $this->masterModelField = $masterModelField;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMasterModelId()
    {
        return $this->masterModelId;
    }

    /**
     * @param mixed $masterModelId
     * @return SecondaryFormBuilder
     */
    public function setMasterModelId($masterModelId)
    {
        $this->masterModelId = $masterModelId;
        return $this;
    }
}