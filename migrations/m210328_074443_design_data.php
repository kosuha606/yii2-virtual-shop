<?php

use app\models\Design;
use app\models\DesignWidget;
use app\models\Lang;
use app\models\Widget;
use yii\db\Migration;

/**
 * Class m210328_074443_design_data
 */
class m210328_074443_design_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            Widget::tableName(),
            [
                'id',
                'name',
                'widget_class',
            ],
            [
                [
                    '1',
                    'Футер',
                    'app\widgets\FooterWidget',
                ],
                [
                    '2',
                    'ГлавноеМеню',
                    'app\widgets\MainMenuWidget',
                ],
                [
                    '3',
                    'Меню',
                    'app\widgets\MenuWidget',
                ],
                [
                    '4',
                    'Текст',
                    'app\widgets\TextWidget',
                ],
                [
                    '5',
                    'Данные',
                    'app\widgets\RawWidget',
                ],
            ]
        );

        $this->insert(Design::tableName(), [
            'name' => 'Основной',
            'route' => '.*',
            'priority' => '1',
            'template' => '%top%

<div class="wrap">
<div class="container">
<div>
%menu%

<div class="panel panel-default" style="margin-top: 20px;">
    %menu_products%
</div>

</div>
%content%
</div>
</div>

%bottom%',
        ]);

        $designTable = Design::tableName();
        $designs = $this->db->createCommand("SELECT * FROM {$designTable}")->queryAll();
        $firstDesign = $designs[0];

        $this->batchInsert(DesignWidget::tableName(), [
            'design_id',
            'widget_id',
            'position',
            'order',
            'config',
        ], [
            [
                $firstDesign['id'],
                3,
                '%menu%',
                1,
                '[{"code":"code","type":"InputField","value":"main"}]'
            ],
            [
                $firstDesign['id'],
                3,
                '%menu_products%',
                1,
                '[{"code":"code","type":"InputField","value":"products"}]'
            ],
            [
                $firstDesign['id'],
                2,
                '%top%',
                1,
                '[]'
            ],
            [
                $firstDesign['id'],
                1,
                '%bottom%',
                1,
                '[{"code":"menus","type":"ConfigBuilderField","value":"[{\"code\":\"code\",\"type\":\"InputField\",\"value\":\"main\"},{\"code\":\"products\",\"type\":\
"InputField\",\"value\":\"products\"}]"}]'
            ]
        ]);

        $this->insert(Lang::tableName(), [
            'code' => 'ru',
            'name' => 'Русский',
            'is_default' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210328_074443_design_data cannot be reverted.\n";
    }
}
