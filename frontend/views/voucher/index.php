<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Json;
use yii\helpers\Url;
use common\models\Voucher;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\VoucherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['restaurant_uuid'] = $restaurant->restaurant_uuid;

$this->title = 'Vouchers';
$this->params['breadcrumbs'][] = $this->title;

$js = "
$(function () {
  $('.summary').insertAfter('.top');
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
                <?= Html::a('Create voucher code', ['create', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>


    <div class="table-responsive">

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function($model) {
                $url = Url::to(['voucher/update', 'id' => $model->voucher_id, 'storeUuid' => $model->restaurant_uuid]);

                return [
                    'onclick' => 'window.location.href=' . Json::htmlEncode($url)
                ];
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'code',
                [
                    'label' => 'Redeemed',
                    "format" => "raw",
                    "value" => function($model) {
                        return $model->getActiveOrders()->count();
                    }
                ],
                [
                    'label' => 'Total spent',
                    "format" => "raw",
                    "value" => function($model) {
                        $totalSpent = $model->getOrders()->where(['restaurant_uuid' => $model->restaurant_uuid])->sum('total_price');

                        return  Yii::$app->formatter->asCurrency($totalSpent ? $totalSpent : 0, $model->restaurant->currency->code, [
                            \NumberFormatter::MAX_FRACTION_DIGITS => $model->restaurant->currency->decimal_place
                        ]) ;

                    }
                ],
                [
                   // 'attribute' => 'discount_amount',
                    'label' => 'Amount',
                    "format" => "raw",
                    "value" => function($model) {
                        return $model->discount_type == Voucher::DISCOUNT_TYPE_PERCENTAGE ? $model->discount_amount . '%' : ($model->discount_amount  ? $model->discount_amount : 'Free Delivery');
                    }
                ],
                'minimum_order_amount',
                [
                    'attribute' => 'voucher_status',
                    "format" => "raw",
                    "filter" => [
                        Voucher::VOUCHER_STATUS_ACTIVE => "Active",
                        Voucher::VOUCHER_STATUS_EXPIRED => 'Expired'
                    ],
                    "value" => function($model) {
                        $voucherStatus = Html::encode($model->voucherStatus);

                        if ($model->voucher_status == Voucher::VOUCHER_STATUS_ACTIVE) {
                            return '<div class="chip chip-success mr-1">
                                          <div class="chip-body">
                                              <span style="white-space: pre;" class="chip-text">' . $voucherStatus . '</span>
                                          </div>
                                      </div>';
                        } else if ($model->voucher_status == Voucher::VOUCHER_STATUS_EXPIRED) {
                            return '<div class="chip chip-danger mr-1">
                                          <div class="chip-body">
                                              <span class="chip-text" style="white-space: pre;">' . $voucherStatus . '</span>
                                          </div>
                                      </div>';
                        }
                    }
                ],
                [
                    'attribute' => 'valid_from',
                    "format" => "raw",
                    "value" => function($model) {
                        return $model->valid_from ? date('Y-m-d', strtotime($model->valid_from)) : null;
                    }
                ],
                [
                    'attribute' => 'valid_until',
                    "format" => "raw",
                    "value" => function($model) {
                        return $model->valid_until ? date('Y-m-d', strtotime($model->valid_until)) : null;
                    }
                ],
                [
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a(
                                           $model->voucher_status == Voucher::VOUCHER_STATUS_ACTIVE ? 'Deactivate' : 'Activate' , ['change-voucher-status', 'id' => $model->voucher_id, 'storeUuid' => $model->restaurant_uuid], [
                                        'title' => $model->voucher_status == Voucher::VOUCHER_STATUS_ACTIVE ? 'Deactivate' : 'Activate',
                                        'data-pjax' => '0',
                                            ]
                            );
                        },
                    ],
                ],
            ],

            'layout' => '{summary}{items}{pager}',
            'tableOptions' => ['class' => 'table dataTable data-list-view']
        ]);
        ?>

      </div>
      <!-- DataTable ends -->

    <?php } else {?>


      <div class="card">
        <div style="padding: 70px 0; text-align: center;">

          <div>
            <img src="https://res.cloudinary.com/plugn/image/upload/v1607881378/emptystate-voucher.svg" width="226" alt="" />
          </div>

          <h3>
            Manage voucher codes
          </h3>

          <p>
            Create voucher codes that apply at checkout.
          </p>
          <?= Html::a('Create voucher code', ['create', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'btn btn-primary']) ?>
        </div>
      </div>


    <?php } ?>

  </section>
  <!-- Data list view end -->
