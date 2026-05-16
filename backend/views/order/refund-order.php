
<?php

use yii\helpers\Html;
use kartik\range\RangeInput;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->params['restaurant_uuid'] = $model->restaurant_uuid;


$this->title = 'Refund';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index', 'storeUuid' => $model->restaurant_uuid]];
$this->params['breadcrumbs'][] = ['label' => 'Order #' . $model->order_uuid, 'url' => ['index', 'storeUuid' => $model->restaurant_uuid]];
$this->params['breadcrumbs'][] = $this->title;

$currency = $order->currency->code;

$js = "
$(document).on('wheel', 'input[type=number]', function (e) {
    $(this).blur();
});

";

$this->registerJs($js);

$encode = static function ($value) {
    return Html::encode((string) $value);
};

?>

<script>

    var itemCounter = 0.000;
    var itemsSubtotal = 0.000;
    var refundedQty = 0;


    function inputHasBeenUpdated(event) {
        var userInput = document.getElementById("refund_amount").value;
        userInput = parseFloat(document.getElementById("refund_amount").value);


          // document.getElementById("refund_amount").value = userInput.toFixed(3) ;
          if(userInput)
            document.getElementById("refund_amount_btn").innerHTML = userInput.toFixed(3)  + ' '+'<?= $currency ?>';
          else
            document.getElementById("refund_amount_btn").innerHTML = '0.000'  + ' '+'<?= $currency ?>';



    }

    function incrementRefundedAmount(event, maxQty, refunded_qty, itemPrice) {

        inputValue = document.getElementById(refunded_qty).value;


        if (inputValue < maxQty) {
            refundedQty = ++document.getElementById(refunded_qty).value;

            itemCounter++;
            itemsSubtotal += parseFloat(itemPrice);

            document.getElementById("items_subtotal").innerHTML = parseFloat(itemsSubtotal).toFixed(3) + ' '+'<?= $currency ?>';
            document.getElementById("refund_total").innerHTML = parseFloat(itemsSubtotal).toFixed(3) + ' '+'<?= $currency ?>';
            document.getElementById("refund_amount_btn").innerHTML = parseFloat(itemsSubtotal).toFixed(3) + ' '+'<?= $currency ?>';
            document.getElementById("refund_amount").value = parseFloat(itemsSubtotal).toFixed(3);

            if (itemCounter > 1)
                $('#refunded_items_qty').text(itemCounter + ' items');
            else
                $('#refunded_items_qty').text(itemCounter + ' item');
        }



        if (itemCounter == 0) {
            $(".no-items").show();
            $(".refund-summary").hide();

        } else {
            $(".no-items").hide();
            $(".refund-summary").show();
        }

    }

    function decrementRefundedAmount(maxQty, refunded_qty, itemPrice) {

        inputValue = document.getElementById(refunded_qty).value;

        if (inputValue > 0) {
            document.getElementById(refunded_qty).value--;
            itemCounter--;
            itemsSubtotal -= parseFloat(itemPrice);

            document.getElementById("items_subtotal").innerHTML = parseFloat(itemsSubtotal).toFixed(3) + ' '+'<?= $currency ?>';
            document.getElementById("refund_total").innerHTML = parseFloat(itemsSubtotal).toFixed(3) + ' '+'<?= $currency ?>';
            document.getElementById("refund_amount_btn").innerHTML = parseFloat(itemsSubtotal).toFixed(3) + ' '+'<?= $currency ?>';
            document.getElementById("refund_amount").value = parseFloat(itemsSubtotal).toFixed(3);

            if (itemCounter > 1)
                $('#refunded_items_qty').text(itemCounter + ' items');
            else
                $('#refunded_items_qty').text(itemCounter + ' item');
        }

        if (itemCounter == 0) {
            $(".no-items").show();
            $(".refund-summary").hide();

        } else {
            $(".no-items").hide();
            $(".refund-summary").show();
        }



    }

</script>

<style>
.input-group{
  position: relative;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  -ms-flex-align: stretch;
  align-items: stretch;
  width: 100%;
}


.input-group-prepend {
    display: flex;
    margin-right: -1px;
}

.input-group > .input-group-prepend > .btn{
  border-top-right-radius: 0;
border-bottom-right-radius: 0;
position: relative;
z-index: 2;
}


.input-group > .form-control:not(:first-child) {
    border-top-left-radius: 0px !important;
    border-bottom-left-radius: 0px !important;
}

.input-group > .form-control:not(:last-child) {
   border-top-right-radius: 0px !important;
   border-bottom-right-radius: 0px !important;
}

</style>
<div class="refund-order">


    <?php
    $form = ActiveForm::begin([
                'enableClientValidation' => false,
                'errorSummaryCssClass' => 'alert alert-danger'

    ]);
    ?>


    <div class="card-body">
      <?= $form->errorSummary([$model], ['header' => '<h4 class="alert-heading">Please fix the following errors:</h4>']); ?>

        <div class="row">
            <div class=" col-12 col-lg-12 col-xl-8">
                <div class="card">

                    <!-- Insert loop here -->
                    <?php
                    foreach ($refunded_items as $refundedItemKey => $refundedItem) {
                      $itemItmage = null;

                      if($refundedItem->orderItem && $refundedItem->orderItem->getItemImage()->one())
                        $itemItmage = $refundedItem->orderItem->getItemImage()->one()->product_file_name;

                      $itemImageSrc = $itemItmage
                          ? 'https://res.cloudinary.com/plugn/image/upload/restaurants/'
                              . rawurlencode((string) $refundedItem->store->restaurant_uuid)
                              . '/items/'
                              . rawurlencode((string) $itemItmage)
                          : null;

                        ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div  class="summary-container">
                                        <div>
                                            <section class="item-img-section">
                                                <?php if($itemItmage){ ?>
                                                  <img class="item-img _3R2Os" src="<?= $encode($itemImageSrc) ?>">
                                                <?php } else { ?>
                                                    <svg
                                                      style="position: absolute; z-index: 10; top: 0; right: 0; bottom: 0; left: 0; margin: auto; max-width: 100%; max-height: 100%; width: 35px;"
                                                      viewBox="0 0 20 20" class="_3vR36 _3DlKx">
                                                      <path d="M2.5 1A1.5 1.5 0 0 0 1 2.5v15A1.5 1.5 0 0 0 2.5 19h15a1.5 1.5 0 0 0 1.5-1.5v-15A1.5 1.5 0 0 0 17.5 1h-15zm5 3.5c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zM16.499 17H3.497c-.41 0-.64-.46-.4-.79l3.553-4.051c.19-.21.52-.21.72-.01L9 14l3.06-4.781a.5.5 0 0 1 .84.02l4.039 7.011c.18.34-.06.75-.44.75z"></path>
                                                  </svg>
                                                <?php } ?>
                                            </section>
                                        </div>
                                        <?php if ($refundedItem && $refundedItem->orderItem) {  ?>
                                              <div class="item-data">
                                                  <!-- Product name -->
                                                  <div>
                                                      <span>
                                                          <?= $encode($refundedItem->orderItem->item_name) ?>
                                                      </span>
                                                  </div>
                                                  <!-- Product description -->
                                                  <div>
                                                      <?php
                                                      if (!empty($refundedItem->orderItem->getOrderItemExtraOptions()->all())) {
                                                          $extraOptions = '';

                                                          foreach ($refundedItem->orderItem->getOrderItemExtraOptions()->all() as $key => $extraOption) {
                                                              if ($key == 0) {
                                                                  $extraOptions .= '<span>' . $encode($extraOption->extra_option_name) . '</span>';
                                                              } else {
                                                                  $extraOptions .= '<span> / ' . $encode($extraOption->extra_option_name) . '</span>';
                                                              }
                                                          }

                                                          echo $extraOptions;
                                                      }
                                                      ?>
                                                      <span>

                                                      </span>
                                                  </div>
                                                  <!-- Product price -->
                                                  <div>
                                                      <?= Yii::$app->formatter->asCurrency(
                                                              $refundedItem->orderItem->item_price * $order->currency_rate,
                                                              $refundedItem->currency->code, [
                                                                  \NumberFormatter::MIN_FRACTION_DIGITS => $refundedItem->currency->decimal_place,
                                                                  \NumberFormatter::MAX_FRACTION_DIGITS => $refundedItem->currency->decimal_place
                                                              ]) ?>
                                                  </div>
                                              </div>
                                          <?php } ?>

                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 text-center">
                                    <div>

                                        <div class="card-body" style="padding: 0px !important">

                                            <div class="form-group field-item-item_price required">
                                                <div class="input-group">
                                                  <?php if ($refundedItem && $refundedItem->orderItem) {

                                                          $order_item_qty = $refundedItem->orderItem->qty;
                                                          $order_item_price = $refundedItem->orderItem->item_price / $order_item_qty;

                                                          // echo $form->field($refundedItem, "[$refundedItemKey]item_uuid")->textInput(['value' => $refundedItem->orderItem->item_uuid,'style'=>'display:none'])->label(false);

                                                          echo $form->field($refundedItem, "[$refundedItemKey]qty", [
                                                              'template' =>
                                                              '  <div class="form-group">
                                                              <div class="input-group">
                                                              <div class="input-group-prepend">' .
                                                          Html::button(
                                                                '-', [
                                                                'class' => 'btn btn-danger bootstrap-touchspin-up',
                                                                'type' => 'button',
                                                                'onclick' => "decrementRefundedAmount('$refundedItem->qty', 'refunded_qty'+$refundedItemKey,'$order_item_price')"
                                                                ])
                                                                . '</div>
                                                                {input}
                                                                <div class="input-group-prepend"> <span class="input-group-text">/ '. $order_item_qty  .'</span> </div>
                                                                <div class="input-group-prepend"> '
                                                              . Html::button(
                                                                '+', [
                                                                'class' => 'btn btn-success bootstrap-touchspin-up',
                                                                'type' => 'button',
                                                                'style' => 'border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;',
                                                                'onclick' => "incrementRefundedAmount(event, '$order_item_qty', 'refunded_qty'+$refundedItemKey,'$order_item_price')"
                                                              ]) .
                                                              '</div>
                                                              ' .
                                                              '</div> </div>'
                                                          ])->textInput([
                                                              'id' => "refunded_qty" . $refundedItemKey,
                                                              'value' => "0",
                                                              'type' => 'number',
                                                              'min' => 0,
                                                              'max'=> $order_item_qty,
                                                              'step' => "1"
                                                          ])->label(false);
                                                        }
                                                        ?>

                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>



                                </div>

                            <span style="color: var(--p-text-subdued,#637381);">
                              Refunded items will be removed from the order.
                            </span>

                            </div>
                        </div>
                      <?php } ?>
                </div>

                <div class="card">
                  <div class="card-body">

                    <div>
                      <!-- <h2 style="font-family: -apple-system,BlinkMacSystemFont,San Francisco,Segoe UI,Roboto,Helvetica Neue,sans-serif; font-weight: 600px !important; line-height: 2.4rem; margin: 0; font-size: 1.6rem;">
                        Reason for refund
                      </h2> -->

                      <?= $form->field($model, 'reason',
                      [
                        'labelOptions' =>
                              [
                                'style' => 'padding-bottom: 20px;font-family: -apple-system,BlinkMacSystemFont,San Francisco,Segoe UI,Roboto,Helvetica Neue,sans-serif; font-weight: 600; line-height: 2.4rem; margin: 0; font-size: 1.4rem'
                              ],
                        'template' => '
                          {label}
                          {input}
                          {hint}
                          {error}
                          <p style="    color: var(--p-text-subdued,#637381);">
                            Only you and other staff can see this reason.
                          </p>'
                      ])->textInput(); ?>

                    </div>

                  </div>
                </div>
            </div>

            <div class="col-12  col-lg-12 col-xl-4">
                <div class="card">
                    <div  class="summary-section">
                        <h2 class="summary-txt">
                            Summary
                        </h2>
                    </div>

                    <div  class="no-items">No items selected.</div>

                    <div class="refund-summary"  style="display:none">

                        <div class="row" style="margin-top:16px">
                            <div class="col-12  col-sm-10 col-md-10 col-lg-8 col-xl-8">
                                <div>
                                    <div><span>Items subtotal</span></div>
                                    <div><span id="refunded_items_qty" style="color: var(--p-text-subdued,#637381);"></span></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2 col-md-2 col-lg-4 col-xl-4">
                                <p id="items_subtotal"></p>
                            </div>
                        </div>


                        <div class="row" style="margin-top:16px">
                            <div class="col-12  col-sm-10 col-md-10 col-lg-8 col-xl-8">
                                <div><span>Refund total</span></div>
                            </div>
                            <div class="col-12 col-sm-2 col-md-2 col-lg-4 col-xl-4">
                                <span id="refund_total"></span>
                            </div>
                        </div>


                    </div>


                    <div  class="refund-section">


                        <h2 class="refund-amount-txt">
                            REFUND AMOUNT
                        </h2>

                        <div style="margin-top: 1.6rem;">
                            <span>
                              <?php

                                if($refundedItem->orderItem)
                                  echo $encode($order->payment_method_name);
                               ?>
                            </span>


                                <?=
                                $form->field($model, 'refund_amount', [
                                    'template' => "{label}"
                                    . "<div class='input-group'> <div class='input-group-prepend'> <span class='input-group-text'>KWD</span> </div>{input}"
                                    . "</div>"
                                    . "{error}{hint}"
                                ])->textInput([
                                    'type' => 'number',
                                    'oninput' => 'inputHasBeenUpdated(event)',
                                    'step' => '0.001',
                                    'min' => 0,
                                    'placeholder' => '0',
                                    'max' => $order->total_price,
                                    'id' => 'refund_amount',
                                    // 'value' => \Yii::$app->formatter->asDecimal(0, 3),
                                    'class' => 'form-control'
                                ])->label(false)
                                ?>

                            <span class="avaliable-amount-to-refund">
                              <?php

                                if($refundedItem->orderItem){

                                  echo Yii::$app->formatter->asCurrency($order->total, $refundedItem->currency->code , [
                                          \NumberFormatter::MIN_FRACTION_DIGITS => $refundedItem->currency->decimal_place,
                                          \NumberFormatter::MAX_FRACTION_DIGITS => $refundedItem->currency->decimal_place
                                  ]);
                                }
                               ?>
                               available for refund
                            </span>

                        </div>
                        <?php

                          if($refundedItem->orderItem){ ?>
                        <div class="form-group refund-btn">
                          <?= Html::submitButton('Refund <span id="refund_amount_btn">0.000 '. $refundedItem->currency->code .'</span>', ['class' => 'btn btn-block bg-success btn-m', 'style' => 'color: white']) ?>
                        </div>
                      <?php } ?>
                                            </div>

                                        </div>




                                    </div>

                                </div>
                            </div>
                        <?php ActiveForm::end(); ?>

</div>
