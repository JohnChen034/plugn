<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Json;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->params['restaurant_uuid'] = $model->restaurant_uuid;

$this->title = 'Update Order: #' . $model->order_uuid;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index', 'storeUuid' => $model->restaurant_uuid]];
$this->params['breadcrumbs'][] = ['label' => 'Order #' . $model->order_uuid, 'url' => ['order/view', 'id' => $model->order_uuid,'storeUuid' => $model->restaurant_uuid]];
$this->params['breadcrumbs'][] = 'Update';


$js = "
$(function () {
  $('.summary').insertAfter('.top');
});
";
$this->registerJs($js);
?>
<div class="order-update">

    <?=
    $this->render('_form', [
        'model' => $model,
        'restaurant' => $restaurant,
    ])
    ?>





    <section id="data-list-view" class="data-list-view-header">

      <h2>Items</h2>


    <!-- Data list view starts -->
    <div class="action-btns">
        <div class="btn-dropdown mr-1 mb-1">
            <div class="btn-group dropdown actions-dropodown">
              <?= Html::a('<i class="feather icon-plus"></i> Add New', ['order-item/create', 'id' => $model->order_uuid, 'storeUuid' => $model->restaurant->restaurant_uuid], ['class' => 'btn btn-outline-primary']) ?>
            </div>
        </div>
    </div>


        <!-- DataTable starts -->
        <div class="table-responsive">

            <?=
            GridView::widget([
                'dataProvider' => $ordersItemDataProvider,
                'rowOptions' => function($model) {
                  if($model->item){
                    $url = Url::to(['order-item/view', 'id' => $model->order_item_id, 'storeUuid' => $model->order->restaurant_uuid]);

                    return [
                        'onclick' => 'window.location.href=' . Json::htmlEncode($url)
                    ];
                  }

                },
                'columns' => [
                  ['class' => 'yii\grid\SerialColumn'],
                  'item_name',
                  [
                      'attribute' => 'item_price',
                      "value" => function($data) use($model) {
                              return Yii::$app->formatter->asCurrency($data->item_price * $model->currency_rate, $data->currency->code, [
                                  \NumberFormatter::MAX_FRACTION_DIGITS => $data->currency->decimal_place
                              ]);
                      },
                  ],
                  'qty',
                  [
                      'label' => 'Extra Options',
                      'value' => function ($data) {
                          $extraOptions = '';

                          foreach ($data->orderItemExtraOptions as $key => $extraOption) {

                              if ($key == 0)
                                  $extraOptions .= $extraOption['extra_option_name'];
                              else
                                  $extraOptions .= ', ' . $extraOption['extra_option_name'];
                          }

                          return $extraOptions;
                      },
                      'format' => 'text'
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
