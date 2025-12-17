<?php

/** @var yii\web\View $this */
/** @var ActiveDataProvider $dataProvider */

use common\models\Apple\Apple;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?= Html::a('Вырастить еще яблок', Url::to(['apple/grow']), ['class' => 'btn btn-success']) ?>

    <div class="mt-3">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => SerialColumn::class],
                [
                    'attribute' => 'color',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function (Apple $apple) {
                        return Html::img("/images/apple-$apple->color.png", ['width' => '50px']);
                    }
                ],
                [
                    'attribute' => 'status',
                    'enableSorting' => false,
                    'value' => function (Apple $apple) {
                        return match ($apple->status) {
                            Apple::STATUS_ON_A_BRANCH => 'Висит на ветке',
                            Apple::STATUS_FELL => 'Лежит на земле',
                            Apple::STATUS_ROTTEN => 'Сгнило',
                        };
                    }
                ],
                [
                    'attribute' => 'eaten',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function (Apple $apple) {
                        return Html::tag('div',
                            Html::tag('div', (100 - $apple->eaten) . '%', [
                                'class' => 'progress-bar',
                                'role' => 'progressbar',
                                'aria-valuenow' => 100 - $apple->eaten,
                                'aria-valuemin' => 0,
                                'aria-valuemax' => 100,
                                'style' => 'width: ' . (100 - $apple->eaten) . '%'
                            ]),
                            ['class' => 'progress']
                        );
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'enableSorting' => false,
                    'value' => function (Apple $apple) {
                        return date('Y-m-d H:i', $apple->created_at);
                    }
                ],
                [
                    'attribute' => 'fell_at',
                    'enableSorting' => false,
                    'value' => function (Apple $apple) {
                        return $apple->fell_at ? date('Y-m-d H:i', $apple->created_at) : 'Еще не упало';
                    }
                ],
                [
                    'label' => 'Действия',
                    'format' => 'raw',
                    'value' => function (Apple $apple) {
                        return '';
                    }
                ]
            ],
        ]) ?>
    </div>
</div>
