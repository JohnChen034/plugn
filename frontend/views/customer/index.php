<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Json;
use common\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['restaurant_uuid'] = $storeUuid;

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;

$js = "
$(function () {
  $('.summary').insertAfter('.top');
});
";


$this->registerJs($js);


$this->registerCss("
  #DataTables_Table_0_filter, #DataTables_Table_0_paginate{
    display:none !important
  }
  .pagination{
    justify-content: center !important;
    margin-top: 1rem !important;
    padding-bottom: 7px !important;

    margin: 2px 0 !important;
white-space: nowrap !important;
  }
  .page-link{
    font-size:0.85rem !important;
    font-weight: 700;
    padding: 0.65rem 0.911rem;
  }
  ");
?>


<section id="data-list-view" class="data-list-view-header">

  <?php  echo $this->render('_search', ['model' => $searchModel,'restaurant_uuid' => $restaurant->restaurant_uuid]); ?>

  <?php if ($count > 0) { ?>

  <!-- Data list view starts -->
  <!-- <div class="action-btns d-none">
      <div class="btn-dropdown mr-1 mb-1">
          <div class="btn-group dropdown actions-dropodown"> -->
            <?php
            // Html::a('Add customer', ['create', 'storeUuid' => $storeUuid], ['class' => 'btn btn-primary']);
             ?>
          <!-- </div>
      </div>
  </div> -->

    <!-- DataTable starts -->
    <div class="table-responsive">

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'rowOptions' => function($model) {
                $url = Url::to(['customer/view', 'id' => $model->customer_id, 'storeUuid' => $model->restaurant_uuid]);

                return [
                    'onclick' => 'window.location.href=' . Json::htmlEncode($url)
                ];
            },
              'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
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

                  [
                      'label' => 'Number of orders',
                      "format" => "raw",
                      "value" => function($model) {
                        return $model->getOrders()
                            ->activeOrders()
                            ->count();
                      }
                  ],
                  // [
                  //     'attribute' => 'Total spent',
                  //     "format" => "raw",
                  //     "value" => function($model) {
                  //       return $model->totalSpent;
                  //
                  //         $total_spent = \Yii::$app->formatter->asDecimal($total_spent ? $total_spent : 0 , 3);
                  //         return  Yii::$app->formatter->asCurrency($total_spent ? $total_spent : 0, $model->currency->code) ;
                  //
                  //     }
                  // ],
                  [
                      'attribute' => 'customer_created_at',
                      "format" => "raw",
                      "value" => function($model) {
                        if ($model->customer_created_at) {
                          return date('d M, Y - h:i A', strtotime($model->customer_created_at));
                        }
                      }
                  ],
              ],
              'layout' => '{summary}{items}{pager}',
              'pager' => [
                'maxButtonCount' => 7,
                'prevPageLabel' => 'Previous',
                'nextPageLabel' => 'Next',
                'prevPageCssClass' => 'paginate_button page-item previous',
                'nextPageCssClass' => 'paginate_button page-item next',
            ],
              'tableOptions' => ['class' => 'table dataTable data-list-view'],
        ]);
        ?>

    </div>
    <!-- DataTable ends -->

  <?php } else {?>


    <div class="card">
      <div style="padding: 70px 0; text-align: center;">

        <div>
          <img src="https://res.cloudinary.com/plugn/image/upload/v1607881378/emptystate-customer.svg" width="226" alt="" />
        </div>

        <h3>
          Manage customer details
        </h3>

        <p>
          This is where you can manage your customer information and view their purchase history.
        </p>
        <?= Html::a('Add customer', ['create', 'storeUuid' => $storeUuid], ['class' => 'btn btn-primary']) ?>
      </div>
    </div>


  <?php } ?>

</section>
<!-- Data list view end -->
