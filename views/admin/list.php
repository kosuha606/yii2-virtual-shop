<?php

/** @var $h1 */
/** @var $ad_url */

$ad_url = $ad_url ?? null;

?>

<div class="content-header">
    <h1><?= $h1 ?></h1>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <?php if ($ad_url) { ?>
                            <a class="btn btn-primary" href="<?= $ad_url ?>">
                                <i class="fa fa-plus"></i>
                                Добавить
                            </a>
                        <?php } ?>

                        <hr>

                        <list
                                :default-sort="_admin.defaultSort"
                                id="list"
                                :entity-url="'/admin/'+_admin.entity"
                                :cell-components="_admin.list_config"
                                :filter-components="_admin.filter_config"
                        >
                        </list>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
