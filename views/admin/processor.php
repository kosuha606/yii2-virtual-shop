<?php

/** @var AdminResponseDTO $response */
/** @var View $this */

use kosuha606\VirtualAdmin\Dto\AdminResponseDTO;
use yii\web\View;

$this->registerJsVar('_admin', $response->jsVars);

?>

<?= $response->html ?>
