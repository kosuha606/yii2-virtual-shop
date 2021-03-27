<?php

namespace app\widgets;

use yii\base\Widget;

class RawWidget extends Widget
{
    public string $raw;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->raw;
    }
}
