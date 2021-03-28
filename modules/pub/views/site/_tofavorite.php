<?php

/** @var ProductVm $product */

use kosuha606\VirtualAdmin\Domains\Multilang\TranslationService;
use kosuha606\VirtualShop\Model\ProductVm;
use kosuha606\VirtualShop\ServiceManager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$user = ServiceManager::getInstance()->userService->current();

$translationService = \kosuha606\VirtualModelHelppack\ServiceManager::getInstance()->get(TranslationService::class);
?>

<?php if ($user->id) { ?>
    <?php if ($product->isInFavorite()) { ?>
        <b>
            <?= Html::a($translationService->translate('Товар в избранном'), ['cabinet/favorites']) ?>
        </b>
    <?php } else { ?>
        <?php $form = ActiveForm::begin(['action' => Url::toRoute('/cabinet/add-favorite'), 'method' => 'post']); ?>

        <input type="hidden" name="product_id" value="<?= $product->id ?>">
        <button class="btn btn-default">
            <?= $translationService->translate('В избранное') ?>
        </button>

        <?php ActiveForm::end(); ?>
    <?php } ?>
<?php } ?>