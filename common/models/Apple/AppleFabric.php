<?php

namespace common\models\Apple;

class AppleFabric
{
    /**
     * @return Apple
     */
    public function createOne(): Apple
    {
        $start = time() - 30 * 24 * 60 * 60;
        $end = time();

        $apple = new Apple();
        $apple->color = Apple::getRandomColor();
        $apple->status = Apple::STATUS_ON_A_BRANCH;
        $apple->eaten = 0;
        $apple->created_at = mt_rand($start, $end);

        return $apple;
    }

    /**
     * @param int $count
     * @return Apple[]
     */
    public function createAny(int $count): array
    {
        $apples = [];

        for ($i = 0; $i < $count; $i++) {
            $apples[] = $this->createOne();
        }

        return $apples;
    }
}