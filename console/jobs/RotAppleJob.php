<?php

namespace console\jobs;

use common\models\Apple\Apple;
use common\models\Apple\AppleRepository;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class RotAppleJob extends BaseObject implements JobInterface
{
    public int $appleId;
    private AppleRepository $appleRepository;

    public function __construct($config = [])
    {
        $this->appleRepository = new AppleRepository();
        parent::__construct($config);
    }

    public function execute($queue)
    {
        $apple = $this->appleRepository->getById($this->appleId);
        if (!$apple) {
            return;
        }

        $apple->status = Apple::STATUS_ROTTEN;

        $this->appleRepository->save($apple);
    }
}