<?php

namespace app\widgets;

use yii\base\Widget;

class RawWidget extends Widget
{
    public $raw;

    public function run()
    {
        return $this->raw;
    }
}