<?php

namespace common\models\Apple;

use console\jobs\RotAppleJob;
use Exception;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;

readonly class AppleService
{
    public function __construct(
        private AppleFabric     $fabric,
        private AppleRepository $repository
    ) {}

    public function dataProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $this->repository->dataProvider(),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ],
            ],
        ]);
    }

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

    /**
     * @param int $id
     * @return string
     * @throws \yii\db\Exception
     */
    public function fall(int $id): string
    {
        $apple = $this->repository->getById($id);

        if ($apple === null) {
            return 'Яблоко не найдено';
        }

        if ($apple->status !== Apple::STATUS_ON_A_BRANCH) {
            return 'Чтобы сбить яблоко с дерева,оно должно быть на дереве';
        }

        $apple->status = Apple::STATUS_FELL;
        $apple->fell_at = time();

        if (!$this->repository->save($apple)) {
            return 'Не удалось сбить яблоко с дерева';
        }

        Yii::$app->queue->delay(5 * 60)
            ->push(new RotAppleJob([
                'appleId' => $apple->id,
            ]));

        return '';
    }

    /**
     * @param int $id
     * @param int $bit
     * @return string
     * @throws \yii\db\Exception
     */
    public function eat(int $id, int $bit): string
    {
        $apple = $this->repository->getById($id);

        if ($apple === null) {
            return 'Яблоко не найдено';
        }

        if ($apple->status === Apple::STATUS_ON_A_BRANCH) {
            return 'Сначало его надо сбить с дерева';
        }

        if ($apple->status === Apple::STATUS_ROTTEN) {
            return 'Не надо есть тухлые яблоки';
        }

        $apple->eaten += $bit;

        $method = 'save';

        if ($apple->eaten >= 100) {
            $method = 'delete';
        }

        if (!$this->repository->$method($apple)) {
            return 'Не удалось отусить яблоко';
        }

        return '';
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\db\Exception
     */
    public function rot(int $id): string
    {
        $apple = $this->repository->getById($id);

        if ($apple === null || $apple->status !== Apple::STATUS_FELL) {
            return 'Яблоко не найдено';
        }

        $apple->status = Apple::STATUS_ROTTEN;

        if (!$this->repository->save($apple)) {
            return 'Яблоко по неизвестным причинам все еще не протухло';
        }

        return '';
    }

    /**
     * @param int $id
     * @return bool
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function delete(int $id): bool
    {
        $apple = $this->repository->getById($id);

        if ($apple === null) {
            return 'Яблоко не найдено';
        }

        if (!$this->repository->delete($apple)) {
            return 'Не удалось выкинуть гнилое яблоко';
        }

        return '';
    }
}