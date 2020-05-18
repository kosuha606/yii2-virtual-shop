<?php

/** @var AdminResponseDTO $response */
/** @var View $this */

use app\virtualModels\Admin\Dto\AdminResponseDTO;
use yii\web\View;

$this->registerJsVar('_admin', $response->jsVars);

?>

<?= $response->html ?>
