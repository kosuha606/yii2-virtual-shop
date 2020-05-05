<?php

namespace app\virtualModels\Dto;

use app\virtualModels\Classes\Pagination;
use app\virtualModels\Model\ProductVm;

class LoadProductsDTO
{
    /** @var ProductVm[] */
    public $products;

    /** @var Pagination */
    public $pagination;

    public function __construct(
        $products,
        $pagination
    ) {
        $this->products = $products;
        $this->pagination = $pagination;
    }
}