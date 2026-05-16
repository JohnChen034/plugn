<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\Order;
use common\models\AgentAssignment;
use yii\helpers\Url;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->params['restaurant_uuid'] = $model->restaurant_uuid;

$this->title = $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index', 'storeUuid' => $model->restaurant_uuid]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">


  <div class="card">
        <div class="card-body">
            <div class="box-body table-responsive no-padding">

                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'customer_name',
                        [
                            'attribute' => 'customer_phone_number',
                            "format" => "raw",
                            "value" => function($model) {
                              $phoneNumber = str_replace(' ', '', $model->customer_phone_number);
                              return Html::a(Html::encode($phoneNumber), 'tel:' . rawurlencode($phoneNumber));
                            }
                        ],
                        'customer_email:email',
                        'customer_created_at',
                        'customer_updated_at',
                    ],
                    'options' => ['class' => 'table table-hover text-nowrap table-bordered'],
                ])
                ?>

            </div>
        </div>
    </div>



        <section id="data-list-view" class="data-list-view-header">
          <h2>Order history</h2>

            <!-- DataTable starts -->
            <div class="table-responsive">

                <?=
                //todo: search feature?
                GridView::widget([
                    'dataProvider' => $customersOrdersData,
                    //'filterModel' => $searchModel,
                    'rowOptions' => function($model) {
                        $url = Url::to(['order/view', 'id' => $model->order_uuid, 'storeUuid' => $model->restaurant_uuid]);

                        return [
                            'onclick' => 'window.location.href=' . Json::htmlEncode($url)
                        ];
                    },
                    'columns' => [
                      //['class' => 'yii\grid\SerialColumn'],
                      [
                          'attribute' => 'order_uuid',
                          "format" => "raw",
                          "value" => function($model) {
                              return '#' . $model->order_uuid;
                          }
                      ],
                      [
                        'attribute' => 'order_mode',
                          'label' => 'Order Type',
                          "format" => "raw",
                          'filter' => [
                            Order::ORDER_MODE_DELIVERY => 'Delivery',
                            Order::ORDER_MODE_PICK_UP => 'Pickup'
                          ],
                          "value" => function($model) {
                              if ($model->order_mode == Order::ORDER_MODE_DELIVERY)
                                  return 'Delivery';
                              else
                                  return 'Pickup';
                          }
                      ],
                      [
                          'attribute' => 'order_status',
                          'format' => "raw",
                          'filter' => [
                            Order::STATUS_DRAFT => 0,
                            Order::STATUS_PENDING => 1,
                            Order::STATUS_BEING_PREPARED => 2,
                            Order::STATUS_OUT_FOR_DELIVERY => 3,
                            Order::STATUS_COMPLETE => 4,
                            Order::STATUS_CANCELED => 5,
                            Order::STATUS_PARTIALLY_REFUNDED => 6,
                            Order::STATUS_REFUNDED => 7,
                            Order::STATUS_ABANDONED_CHECKOUT => 9,
                            Order::STATUS_ACCEPTED => 10
                          ],
                          'value' => function($model) {
                              if ($model->order_status == Order::STATUS_PENDING)
                                  return '<span class="badge bg-warning" >' . Html::encode($model->orderStatusInEnglish) . '</span>';
                              else if ($model->order_status == Order::STATUS_ACCEPTED)
                                  return '<span class="badge" style="background-color:#2898C8;" >' . Html::encode($model->orderStatusInEnglish) . '</span>';
                              else if ($model->order_status == Order::STATUS_DRAFT)
                                  return '<span class="badge bg-info" >' . Html::encode($model->orderStatusInEnglish) . '</span>';
                              else if ($model->order_status == Order::STATUS_OUT_FOR_DELIVERY)
                                  return '<span class="badge bg-info" >' . Html::encode($model->orderStatusInEnglish) . '</span>';
                              else if ($model->order_status == Order::STATUS_BEING_PREPARED)
                                  return '<span class="badge bg-primary" >' . Html::encode($model->orderStatusInEnglish) . '</span>';
                              else if ($model->order_status == Order::STATUS_COMPLETE)
                                  return '<span class="badge bg-success" >' . Html::encode($model->orderStatusInEnglish) . '</span>';
                              else if ($model->order_status == Order::STATUS_CANCELED)
                                  return '<span class="badge bg-danger" >' . Html::encode($model->orderStatusInEnglish) . '</span>';
                              else if ($model->order_status == Order::STATUS_PARTIALLY_REFUNDED)
                                  return '<span class="badge bg-warning" >' . Html::encode($model->orderStatusInEnglish) . '</span>';
                              else if ($model->order_status == Order::STATUS_REFUNDED)
                                  return '<span class="badge bg-danger" >' . Html::encode($model->orderStatusInEnglish) . '</span>';
                              else if ($model->order_status == Order::STATUS_ABANDONED_CHECKOUT)
                                  return '<span class="badge bg-danger" >' . Html::encode($model->orderStatusInEnglish) . '</span>';
                          }
                      ],
                      [
                          'attribute' => 'delivery_fee',
                          "value" => function($data) {
                                  return Yii::$app->formatter->asCurrency($data->delivery_fee, $data->currency->code, [
                                      \NumberFormatter::MAX_FRACTION_DIGITS => $data->currency->decimal_place
                                  ]);
                          },
                      ],
                      [
                          'attribute' => 'total_price',
                          "value" => function($data) {
                                  return Yii::$app->formatter->asCurrency($data->total, $data->currency->code, [
                                      \NumberFormatter::MAX_FRACTION_DIGITS => $data->currency->decimal_place
                                  ]);
                          },
                      ],
                      [
                          'attribute' => 'order_created_at',
                          "format" => "raw",
                          "value" => function($model) {
                              return date('d M - h:i A', strtotime($model->order_created_at));
                          }
                      ],
                    ],
                    'layout' => '{summary}{items}{pager}',
                    'tableOptions' => ['class' => 'table dataTable data-list-view'],
                ]);
                ?>

            </div>
            <!-- DataTable ends -->

          </section>
        <!-- Data list view end -->
      </div>
