<?php

namespace common\models\Apple;

use yii\db\ActiveQuery;
use yii\db\Exception;

class AppleRepository
{
    public function dataProvider(): ActiveQuery
    {
        return Apple::find();
    }

    /**
     * @param Apple $apple
     * @return bool
     * @throws Exception
     */
    public function save(Apple $apple): bool
    {
        return $apple->save();
    }
}