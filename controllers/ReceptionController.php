<?php

namespace app\controllers;

use app\models\Reception;
use app\models\ReceptionSearch;
use app\models\Status;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReceptionController implements the CRUD actions for Reception model.
 */
class ReceptionController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * @return User
     */
    public function getUser() {
        return Yii::$app->user->identity;
    }

    /**
     * Lists all Reception models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = self::getUser();
        if (!$user) {
            return $this->goHome();
        }
        $userIds = null;
        if (!$user->isAdmin()) {
            $userIds = $user->id;
        }

        $searchModel = new ReceptionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $userIds);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reception model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Reception model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Reception();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_id = Yii::$app->user->identity->id;
                $model->status_id = Status::NEW_STATUS;
                if ($model->save()) {
                    return $this->redirect(['index', 'id' => $model->id]);
                }      
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Report model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Reception model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Reception the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reception::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
