<?php

namespace app\virtualModels\Classes;

class Pagination
{
    public $itemPerPage = 10;

    public $page = 1;

    public $totals = 0;

    public function __construct($page, $itemPerPage)
    {

        $this->page = $page;
        $this->itemPerPage = $itemPerPage;
    }

    public function getLimit()
    {
        return $this->itemPerPage;
    }

    public function getOffset()
    {
        return ($this->page-1)*$this->itemPerPage;
    }

    public function getPages()
    {
        $pages = ceil($this->totals/$this->itemPerPage);

        return $pages;
    }
}