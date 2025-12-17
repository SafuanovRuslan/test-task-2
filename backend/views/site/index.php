<?php

/** @var yii\web\View $this */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?= Html::a('Вырастить еще яблок', Url::to(['apple/grow']), ['class' => 'btn btn-success']) ?>

    <div class="mt-3">
        <?= GridView::widget([
                'dataProvider' => new ArrayDataProvider([]),
                'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                                'class' => 'yii\grid\ActionColumn',
                        ],
                ],
        ]) ?>
    </div>
</div>
