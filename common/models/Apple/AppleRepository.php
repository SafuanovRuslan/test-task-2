<?php

namespace common\models\Apple;

use yii\db\Exception;

class AppleRepository
{
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