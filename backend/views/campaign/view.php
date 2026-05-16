<?php

use yii\db\Expression;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Campaign */
/* @var $searchModel backend\models\RestaurantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->utm_uuid;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);

$queryParams = [
    'utm_source' => $model->utm_source,
    'utm_medium' => $model->utm_medium,
    'utm_campaign' => $model->utm_campaign,
    'utm_id' => $model->utm_uuid,
    'utm_term' => $model->utm_term,
    'utm_content' => $model->utm_content,
];
$queryString = http_build_query($queryParams, '', '&', PHP_QUERY_RFC3986);
$urlParams = '?' . $queryString;
$dashboardAppUrl = rtrim(Yii::$app->params['dashboardAppUrl'], '/');
$campaignUrl = $dashboardAppUrl . $urlParams;
$registrationUrl = $dashboardAppUrl . '/register' . $urlParams;

?>
<div class="campaign-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->utm_uuid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->utm_uuid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <?php if ($model->no_of_signups > 0) {
            echo Html::a('Agents by this campaign', [
                'agent/index', 'id' => $model->utm_uuid,
                'AgentSearch[utm_uuid]' => $model->utm_uuid,
            ], ['class' => 'btn btn-primary']);
        } ?>
    </p>

    <h3>Campaign URL</h3>

    <?= Html::a(Html::encode($campaignUrl), $campaignUrl, ['target' => '_blank', 'rel' => 'noopener noreferrer']) ?>

    <br/>
    <br/>

    <?= Html::a(Html::encode($registrationUrl), $registrationUrl, ['target' => '_blank', 'rel' => 'noopener noreferrer']) ?>


    <br/>
    <br/>

    <p>or any url with `<i><?= Html::encode($urlParams) ?></i>` </p>

    <h3>Campaign detail</h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'utm_uuid',
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_content',
            'utm_term',
            'investment',
            'no_of_clicks',
            'no_of_signups',
            'no_of_stores',
            'no_of_orders',
            'total_commission',
            'total_gateway_fee',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <h3>Stores</h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        /*'rowOptions' => function($model){
            if ($model->queue) {
                if ($model->queue->queue_status == \common\models\Queue::QUEUE_STATUS_PENDING) {
                    return ['class' => 'danger'];
                } else if ($model->queue->queue_status == \common\models\Queue::QUEUE_STATUS_HOLD) {
                    return ['style' => 'background:orange', 'title' => 'Hold'];
                }
            }
        },*/
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'restaurant_uuid',
            'name',
            'restaurant_domain',
            'restaurant_created_at:date',

            [
                'label' => "Store revenue",
                'format' => "html",
                'value' => function ($model) {

                    $payments = $model->getCSV();

                    if(empty($payments)) {
                        return "No order(s)!";
                    }

                    $values = [];

                    foreach ($payments as $payment) {

                        $values[] = Yii::$app->formatter->asCurrency($payment['payment_net_amount'], $payment['currency_code']);
                    }

                    return implode(", ", $values);
                }
            ],

            [
                'label' => "Plugn fees",
                'format' => "html",
                'value' => function ($model) {

                    $payments = $model->getCSV();

                    $values = [];

                    foreach ($payments as $payment) {

                        $values[] = Yii::$app->formatter->asCurrency($payment['plugn_fees'], $payment['currency_code']);
                    }

                    return implode(", ", $values);
                }
            ],

            [
                'label' => "Payment gateway fees",
                'format' => "html",
                'value' => function ($model) {

                    $payments = $model->getCSV();

                    $values = [];

                    foreach ($payments as $payment) {

                        $values[] = Yii::$app->formatter->asCurrency($payment['payment_gateway_fees'], $payment['currency_code']);
                    }

                    return implode(", ", $values);
                }
            ],

            [
                'label' => "Partner fees",
                'format' => "html",
                'value' => function ($model) {

                    $payments = $model->getCSV();

                    $values = [];

                    foreach ($payments as $payment) {

                        $values[] = Yii::$app->formatter->asCurrency($payment['partner_fees'], $payment['currency_code']);
                    }

                    return implode(", ", $values);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $data) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye"></span>',
                            ['restaurant/view', 'id' => $data->restaurant_uuid],
                            [
                                'title' => 'View',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>
