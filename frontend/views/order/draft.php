<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Order;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['restaurant_uuid'] = $restaurant->restaurant_uuid;

$this->title = 'Drafts';
$this->params['breadcrumbs'][] = $this->title;
$js = "
$(function () {
  $('.summary').insertAfter('.top');

  $('input[name=\"OrderSearch[order_created_at]\"]').datepicker({
    format: 'd M yyyy',
  });

});
";
$this->registerJs($js);
?>

<section id="data-list-view" class="data-list-view-header">

  <?php if ($count > 0) { ?>

    <!-- Data list view starts -->
    <div class="action-btns">
        <div class="btn-dropdown mr-1 mb-1">
            <div class="btn-group dropdown actions-dropodown">
              <?= Html::a('Create draft order ', ['create', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>


    <!-- DataTable starts -->
    <div class="table-responsive">

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
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
                    'label' => 'Order ID',
                    "format" => "raw",
                    "value" => function($model) {
                        return '#' . $model->order_uuid;
                    }
                ],
                [
                    'attribute' => 'customer_name',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if ($data->customer_id)
                            return Html::a(Html::encode($data->customer->customer_name), ['customer/view', 'id' => $data->customer_id, 'storeUuid' => $data->restaurant_uuid]);
                    },
                    'visible' => function ($data) {
                        return $data->customer_id ? true : false;
                    },
                ],
                [
                    'label' => 'Payment',
                    "format" => "text",
                    "value" => function($data) {
                        if ($data->payment_uuid)
                            return $data->payment->payment_current_status;
                        else if($data->paymentMethod)
                            return $data->paymentMethod->payment_method_name;
                    },
                ],
                [
                    'attribute' => 'total_price',
                    "value" => function($model) {
                        return Yii::$app->formatter->asCurrency($model->total, $model->currency_code, [
                            \NumberFormatter::MAX_FRACTION_DIGITS => $model->currency? $model->currency->decimal_place: 3
                        ]);
                    },
                ],
                /*[
                    'attribute' => 'order_created_at',
                    "format" => "raw",
                    "value" => function($model) {
                        return date('d M - h:i A', strtotime($model->order_created_at));
                    }
                ],*/
                'order_created_at:datetime',
            ],
            'layout' => '{summary}{items}{pager}',
            'tableOptions' => ['class' => 'table dataTable data-list-view'],
        ]);
        ?>

    </div>
    <!-- DataTable ends -->

  <?php } else {?>



    <div class="card">
      <div style="padding: 70px 0; text-align: center;">

        <div>
          <img src="https://res.cloudinary.com/plugn/image/upload/v1607879689/empty-state.svg" width="226" alt="" />
        </div>

        <h3>
          Manually create orders and invoices
        </h3>

        <p>
          Use draft orders to take orders over the phone, email invoices to customers, and collect payments.
        </p>
        <?= Html::a('Create draft order', ['create', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'btn btn-primary']) ?>
      </div>
    </div>


  <?php } ?>

</section>
<!-- Data list view end -->
