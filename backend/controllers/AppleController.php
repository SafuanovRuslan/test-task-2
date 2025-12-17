<?php

namespace backend\controllers;

use common\models\Apple\AppleService;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class AppleController extends Controller
{
    public function __construct(
        $id,
        $module,
        private AppleService $service,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['grow'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'grow' => ['get'],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return Response
     */
    public function actionGrow()
    {
        if ($this->service->createApples()) {
            Yii::$app->session->setFlash('success', 'В саду появились новые яблоки');

            return $this->redirect(['site/index']);
        }

        Yii::$app->session->setFlash('danger', 'Не удалось вырастить новый урожай');

        return $this->redirect(['site/index']);
    }
}
