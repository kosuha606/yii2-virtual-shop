<?php

namespace app\virtualModels\Admin\Form;

/**
 * Сервис отвечающий за работу с второстепенными формами сущности
 */
class SecondaryFormService
{
    /**
     * Построить форму
     * @return SecondaryFormBuilder
     */
    public function buildForm(): SecondaryFormBuilder
    {
        return new SecondaryFormBuilder($this);
    }

    /**
     * Запомнить форму
     * @param SecondaryFormBuilder $builder
     */
    public function rememberForm(SecondaryFormBuilder $builder)
    {

    }

    /**
     * Выполнить обработку запомненных форм
     */
    public function processRememberedForm()
    {

    }
}