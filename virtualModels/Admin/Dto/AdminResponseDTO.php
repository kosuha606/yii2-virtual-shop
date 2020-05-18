<?php

namespace app\virtualModels\Admin\Dto;

class AdminResponseDTO
{
    public $html = '';

    public $json = [
        'result' => true,
    ];

    public $jsVars = [];

    public function __construct($html, $jsVars)
    {
        $this->html = $html;
        $this->jsVars = $jsVars;
    }
}