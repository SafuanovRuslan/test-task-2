<?php

namespace common\models\Apple;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string  $color
 * @property integer $status
 * @property integer $eaten
 * @property integer $created_at
 * @property integer $fell_at
 */
class Apple extends ActiveRecord
{
    public const STATUS_ON_A_BRANCH = 1;
    public const STATUS_FELL = 2;
    public const STATUS_ROTTEN = 3;

    public const COLORS = ['red', 'green', 'yellow'];

    public static function tableName(): string
    {
        return '{{%apples}}';
    }

    public function rules(): array
    {
        return [
            [['color', 'status', 'eaten', 'created_at'], 'required'],
            [['color'], 'string'],
            [['status', 'eaten', 'created_at', 'fell_at'], 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'color' => 'Цвет',
            'status' => 'Состояние',
            'eaten' => 'Откушено',
            'created_at' => 'Дата созревания',
            'fell_at' => 'Упало с ветки',
        ];
    }

    public static function getRandomColor(): string
    {
        return self::COLORS[array_rand(self::COLORS)];
    }
}