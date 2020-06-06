<?php


namespace app\virtualModels\Admin\Domains\Seo;


interface SeoModelInterface
{
    public function buildUrl();

    public function getSeo(): SeoPageVm;
}