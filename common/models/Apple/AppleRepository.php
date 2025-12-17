<?php

namespace common\models\Apple;

use Throwable;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\db\StaleObjectException;

class AppleRepository
{
    public function dataProvider(): ActiveQuery
    {
        return Apple::find();
    }

    /**
     * @param int $id
     * @return Apple|null
     */
    public function getById(int $id): ?Apple
    {
        return Apple::findOne($id);
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

    /**
     * @param Apple $apple
     * @return bool
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function delete(Apple $apple): bool
    {
        return $apple->delete();
    }
}