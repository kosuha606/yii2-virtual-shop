<?php

namespace app\virtualModels\Admin\Domains\Seo;

class SeoFilterService
{
    /**
     * Создать урл из данных фильтров
     *
     * @param array $data
     * @return bool|string
     * @throws \Exception
     */
    public function createUrl($data = [])
    {
        $urlParts = [];

        foreach ($data as $index => $item) {
            $itemParts = explode('_', $item);
            $filter = SeoFilterVm::one(['where' => [
                ['=', 'value', $itemParts[0]],
                ['=', 'type', $itemParts[1]],
            ]]);

            if ($filter) {
                $order = $filter->order ?: $index;
                $urlParts[] = [
                    'slug' => $filter->slug,
                    'order' => (int)$order
                ];
            }
        }

        uasort($urlParts, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        $urlParts = array_column($urlParts, 'slug');

        if (count($data) === count($urlParts)) {
            return implode('_', $urlParts);
        }

        return false;
    }

    /**
     * Распарсить урл в данные
     * @param $url
     * @return array
     * @throws \Exception
     */
    public function parseUrl($url)
    {
        $slugs = explode('_', $url);
        $filter = [];
        $seoFilters = SeoFilterVm::many(['where' => [
            ['in', 'slug', $slugs],
        ]]);

        /** @var SeoFilterVm $seoFilter */
        foreach ($seoFilters as $seoFilter) {
            $filter[] = $seoFilter->value.'_'.$seoFilter->type;
        }

        return $filter;
    }

    public function urlWithoutFilter($url)
    {
        $urlParts = explode('filter-', $url);

        return '/' . rtrim($urlParts[0], '/');
    }

    /**
     * @param $value
     * @param $type
     * @return bool
     * @throws \Exception
     */
    public function saveFilterValueIfNotExists($value, $type)
    {
        $existed = SeoFilterVm::many(['where' => [
            ['=', 'value', $value],
            ['=', 'type', $type],
        ]]);

        if ($existed) {
            return false;
        }

        SeoFilterVm::create([
            'value' => $value,
            'type' => $type,
        ])->save();
    }
}