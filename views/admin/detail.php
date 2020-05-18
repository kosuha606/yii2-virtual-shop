<?php

/** @var $h1 */

?>

<h1><?= $h1 ?></h1>

<detail
    :id="_admin.model.id"
    :save-url="'/admin/'+_admin.entity+'/detail'"
    :item="_admin.model"
    :detail-components="_admin.config">

</detail>
