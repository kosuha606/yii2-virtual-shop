<?php


use kosuha606\VirtualShop\Model\OrderVm;

/** @var OrderVm[] $orders */

?>

<h1>Заказы</h1>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">

        <table class="table table-bordered table-striped">
            <?php if (!$orders) { ?>
                <b>Нету товаров</b>
            <?php } ?>
            <?php foreach ($orders as $order) { ?>
            <tr>
                <td width="1%" class="text-nowrap">
                    № <?= $order->id ?>
                </td>
                <td>
                    <div>
                        <b>Состав заказа:</b>
                        <table class="table table-bordered">
                            <?php foreach ($order->orderData['items'] as $orderItem) { ?>
                                <tr>
                                    <td>
                                        <?= $orderItem['name'] ?>
                                    </td>
                                    <td>
                                        <?= $orderItem['price'] ?> руб.
                                    </td>
                                    <td>
                                        <?= $orderItem['qty'] ?> шт.
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div>
                        <b>Оплата:</b>
                        <?= $order->orderData['payment']['description'] ?>
                        <?= $order->orderData['payment']['comission'] ?> руб.
                    </div>
                    <div>
                        <b>Доставка:</b>
                        <?= $order->orderData['delivery']['description'] ?>
                        <?= $order->orderData['delivery']['price'] ?> руб.
                    </div>
                    <div>
                        <b>Итог:</b>
                        <?= $order->total ?> руб.
                    </div>
                </td>
            </tr>
            <?php } ?>
        </table>

    </div>
</div>