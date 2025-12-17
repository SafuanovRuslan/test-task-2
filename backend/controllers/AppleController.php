<?php

namespace backend\controllers;

use common\models\Apple\AppleService;
use Yii;
use yii\db\Exception;
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
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['grow', 'eat', 'fall', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'grow' => ['get'],
                    'eat' => ['post'],
                    'fall' => ['get'],
                    'delete' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return Response
     */
    public function actionGrow(): Response
    {
        if ($this->service->createApples()) {
            Yii::$app->session->setFlash('success', 'В саду появились новые яблоки');

            return $this->redirect(['site/index']);
        }

        Yii::$app->session->setFlash('danger', 'Не удалось вырастить новый урожай');

        return $this->redirect(['site/index']);
    }

    public function actionEat(): Response
    {
        $id = Yii::$app->request->post('id');
        $bit = abs(Yii::$app->request->post('bit'));

        if (!$error = $this->service->eat($id, $bit)) {
            Yii::$app->session->setFlash('success', 'Отличный укус, приятного аппетита');

            return $this->redirect(['site/index']);
        }

        Yii::$app->session->setFlash('danger', $error);

        return $this->redirect(['site/index']);
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function actionFall(): Response
    {
        $id = Yii::$app->request->get('id');

        if (!$error = $this->service->fall($id)) {
            Yii::$app->session->setFlash('success', 'Отлично, теперь его можно съесть');

            return $this->redirect(['site/index']);
        }

        Yii::$app->session->setFlash('danger', $error);

        return $this->redirect(['site/index']);
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function actionDelete(): Response
    {
        $id = Yii::$app->request->get('id');

        if (!$error = $this->service->delete($id)) {
            Yii::$app->session->setFlash('success', 'Хорошая работа, на один тухляк меньше');

            return $this->redirect(['site/index']);
        }

        Yii::$app->session->setFlash('danger', $error);

        return $this->redirect(['site/index']);
    }
}
