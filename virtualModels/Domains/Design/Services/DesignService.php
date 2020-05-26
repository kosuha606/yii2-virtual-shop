<?php

namespace app\virtualModels\Domains\Design\Services;

use app\virtualModels\Domains\Design\Models\DesignVm;
use app\virtualModels\Domains\Design\Models\DesignWidgetVm;
use app\virtualModels\Domains\Design\Models\WidgetVm;
use yii\base\Widget;

class DesignService
{
    /**
     * @param $content
     * @return string
     * @throws \Exception
     */
    public function renderDesignForRoute($content)
    {
        $route = \Yii::$app->requestedRoute ?: 'site/index';
        $designs = DesignVm::many(['where' => [['all']]]);

        /** @var DesignVm $matchedDesign */
        $matchedDesign = null;

        /** @var DesignVm $design */
        foreach ($designs as $design) {
            if (preg_match("/{$design->route}/i", $route)) {
                if (!$matchedDesign) {
                    $matchedDesign = $design;
                } elseif($matchedDesign->priority < $design->priority) {
                    $matchedDesign = $design;
                }
            }
        }

        if (!$matchedDesign) {
            throw new \Exception('Для текущего роута не найден дизайн');
        }

        /** @var DesignWidgetVm[] $widgets */
        $widgets = DesignWidgetVm::many(['where' => [['=', 'design_id', $matchedDesign->id]]]);

        $template = $matchedDesign->template;
        $positionTemplates = [];

        foreach ($widgets as $designWidget) {
            if (!isset($positionTemplates[$designWidget->position])) {
                $positionTemplates[$designWidget->position] = [];
            }

            $widget = WidgetVm::one(['where' => [['=', 'id', $designWidget->widget_id]]]);
            /** @var Widget $widgetClass */
            $widgetClass = $widget->widget_class;
            $widgetConfig = json_decode($designWidget->config, true);
            $widgetConfig = $this->normalizeWidgetConfig($widgetConfig);
            $positionTemplates[$designWidget->position][] = [
                'order' => $designWidget->order,
                'content' => $widgetClass::widget($widgetConfig)
            ];
        }

        foreach ($positionTemplates as $position => &$positionTemplate) {
            uasort($positionTemplate, function($a, $b) {
                return $a['order'] <=> $b['order'];
            });

            foreach ($positionTemplate as $positionTemplateContent) {
                $template = str_replace($position, $positionTemplateContent['content'].$position, $template);
            }

            $template = str_replace($position, '', $template);
        }


        return str_replace('%content%', $content, $template);
    }

    public function normalizeWidgetConfig($widgetConfig)
    {
        $result = [];

        if (isset($widgetConfig['value'])) {
            return $widgetConfig['value'];
        }

        foreach ($widgetConfig as $value) {
            $data = json_decode($value['value'], true);
            if (!$data) {
                $result[$value['code']] = $value['value'];
            } else {
                $result[$value['code']] = $this->normalizeWidgetConfig($data);
            }
        }

        return $result;
    }
}