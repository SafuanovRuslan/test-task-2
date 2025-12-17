<?php

namespace common\models\Apple;

use Exception;
use Yii;

readonly class AppleService
{
    public function __construct(
        private AppleFabric     $fabric,
        private AppleRepository $repository
    ) {}

    /**
     * @return bool
     */
    public function createApples(): bool
    {
        $apples = $this->fabric->createAny(rand(1, 10));

        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($apples as $apple) {
                $this->repository->save($apple);
            }

            $transaction->commit();

            return true;
        } catch (Exception) {
            $transaction->rollBack();

            return false;
        }
    }
}