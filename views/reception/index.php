<?php

use app\models\Reception;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ReceptionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Receptions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reception-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if(Yii::$app->user->identity->role_id == '1') {
                echo Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ;
            }
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'patient_fio',
            'date_of_reception',
            'description:ntext',
            'status',
            [
                'attribute'=> 'status',
                //смена статуса вмдна только админу
                'visible' => (Yii::$app->user->identity->role_id == '2')?true:false,
                'format'=> 'raw',
                'value'=> function ($data) {
                    $html = Html::beginForm(Url::to(['update', 'id' => $data->id]));
                    $html .= Html::activeDropDownList($data, 'status_id', [
                        1 => 'Подтверждено',
                        2 => 'Отклонено',
                    ],
                    [
                        'prompt' => [
                            'text'=> 'new',
                            'options' => [
                                'value'=> '3',
                                'style'=> 'display: none',
                            ]
                        ]
                    ]);
                    $html .= Html::submitButton('Принять', ['class' => 'btn btn-link']);
                    $html .= Html::endForm();
                    return $html;
                }
            ],
        ],
    ]); ?>


</div>
