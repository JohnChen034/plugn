<?php

use yii\helpers\Html;
use common\models\Restaurant;

/* @var $this yii\web\View */
/* @var $store common\models\Restaurant */
/* @var $agent_name  */
/* @var $revenuePercentage */
/* @var $ordersReceivedPercentage */
/* @var $customerGainedPercentage */
/* @var $thisWeekRevenue */
/* @var $thisWeekOrdersReceived */
/* @var $thisWeekCustomerGained */



$statsUrl = Yii::$app->params['frontendUrl'] . '/store/statistics?storeUuid=' . $store->restaurant_uuid;
$agentProfileUrl = Yii::$app->params['frontendUrl'] . '/agent/update?storeUuid=' . $store->restaurant_uuid;
$storeNameLabel = Html::encode($store->name);
$agentNameLabel = Html::encode($agent_name);

?>


    <!doctype html>
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
      <head>
        <title>
          Weekly store summary for <?= $storeNameLabel ?>
        </title>
        <!--[if !mso]><!-- -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<![endif]-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
          #outlook a { padding:0; }
          .ReadMsgBody { width:100%; }
          .ExternalClass { width:100%; }
          .ExternalClass * { line-height:100%; }
          body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
          table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
          img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
          p { display:block;margin:13px 0; }
        </style>
        <!--[if !mso]><!-->
        <style type="text/css">
          @media only screen and (max-width:480px) {
            @-ms-viewport { width:320px; }
            @viewport { width:320px; }
          }
        </style>
        <!--<![endif]-->
        <!--[if mso]>
        <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
        <![endif]-->
        <!--[if lte mso 11]>
        <style type="text/css">
          .outlook-group-fix { width:100% !important; }
        </style>
        <![endif]-->


    <style type="text/css">
      @media only screen and (min-width:480px) {
        .mj-column-per-100 { width:100% !important; max-width: 100%; }
.mj-column-per-33 { width:33.333333333333336% !important; max-width: 33.333333333333336%; }
      }
    </style>


        <style type="text/css">



    @media only screen and (max-width:480px) {
      table.full-width-mobile { width: 100% !important; }
      td.full-width-mobile { width: auto !important; }
    }

        </style>


      </head>
      <body style="background-color:#ffffff;">


      <div
         style="background-color:#ffffff;"
      >


      <!--[if mso | IE]>
      <table
         align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
      >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->


      <div  style="Margin:0px auto;max-width:600px;">

        <table
           align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"
        >
          <tbody>
            <tr>
              <td
                 style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:5px;text-align:center;vertical-align:top;"
              >
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">

        <tr>

        </tr>

                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>

      </div>


      <!--[if mso | IE]>
          </td>
        </tr>
      </table>

      <table
         align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
      >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->


      <div  style="Margin:0px auto;max-width:600px;">

        <table
           align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"
        >
          <tbody>
            <tr>
              <td
                 style="border:1px solid #d8e2e7;direction:ltr;font-size:0px;padding:20px 0;padding-top:0;text-align:center;vertical-align:top;"
              >
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">

            <tr>
              <td
                 class="" width="600px"
              >

        <table
           align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:598px;" width="598"
        >
          <tr>
            <td  style="line-height:0;font-size:0;mso-line-height-rule:exactly;">
              <v:image
                 style="border:0;height:142px;mso-position-horizontal:center;position:absolute;top:0;width:631px;z-index:-3;" src="https://res.cloudinary.com/plugn/image/upload/v1618264268/plugn-bg_x4wd91.png" xmlns:v="urn:schemas-microsoft-com:vml"
              />
      <![endif]-->
      <div
         style="margin:0 auto;max-width:598px;"
      >
        <table
           border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"
        >
          <tr
             style="vertical-align:top;"
          >

          <td
             background="https://res.cloudinary.com/plugn/image/upload/v1618264268/plugn-bg_x4wd91.png" style="background:#2B546A url(https://res.cloudinary.com/plugn/image/upload/v1618264268/plugn-bg_x4wd91.png) no-repeat center center / cover;background-position:center center;background-repeat:no-repeat;padding:0px;vertical-align:top;" height="142"
          >

      <!--[if mso | IE]>
        <table
           border="0" cellpadding="0" cellspacing="0" style="width:598px;" width="598"
        >
          <tr>
            <td  style="">
      <![endif]-->
      <div
         class="mj-hero-content" style="margin:0px auto;"
      >
        <table
           border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;margin:0px;"
        >
          <tr>
            <td  style="" >
              <table
                 border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;margin:0px;"
              >

                    <tr>
                      <td
                         align="left" style="font-size:0px;padding:0;padding-top:30px;padding-left:30px;word-break:break-word;"
                      >

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"
      >
        <tbody>
          <tr>
            <td  style="width:93px;">

      <img
         height="auto" src="https://res.cloudinary.com/plugn/image/upload/v1618264194/plugn-white_egzahs.png" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;" width="93"
      />

            </td>
          </tr>
        </tbody>
      </table>

                      </td>
                    </tr>

                    <tr>
                      <td
                         align="left" style="font-size:0px;padding:20px;padding-top:40px;padding-bottom:0;padding-left:30px;word-break:break-word;"
                      >

      <div
         style="font-family:Helvetica;font-size:21px;font-weight:900;line-height:24px;text-align:left;color:#ffffff;"
      >
        Weekly Store Summary
      </div>

                      </td>
                    </tr>

                    <tr>
                      <td
                         align="left" style="font-size:0px;padding:20px;padding-top:5px;padding-left:30px;word-break:break-word;"
                      >

      <div
         style="font-family:Helvetica;font-size:16px;line-height:24px;text-align:left;color:#ffffff;"
      >
        <?= date("M d", mktime(23, 59, 59, date("m"),  date("d") -7)) . ' - '  . date("M d, Y", mktime(23, 59, 59, date("m"),  date("d"))) ?>
      </div>

                      </td>
                    </tr>

              </table>
            </td>
          </tr>
        </table>
      </div>
      <!--[if mso | IE]>
            </td>
          </tr>
        </table>
      <![endif]-->

          </td>

          </tr>
      </table>
    </div>
    <!--[if mso | IE]>
          </td>
        </tr>
      </table>

              </td>
            </tr>

            <tr>
              <td
                 class="" width="600px"
              >

      <table
         align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:598px;" width="598"
      >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->


      <div  style="Margin:0px auto;max-width:598px;">

        <table
           align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"
        >
          <tbody>
            <tr>
              <td
                 style="direction:ltr;font-size:0px;padding:0px;text-align:center;vertical-align:top;"
              >
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">

        <tr>

            <td
               class="" style="vertical-align:top;width:598px;"
            >
          <![endif]-->

      <div
         class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"
      >

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"
      >

            <tr>
              <td
                 align="left" style="font-size:0px;padding:10px 25px;padding-top:25px;padding-bottom:0;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:14px;line-height:24px;text-align:left;color:#000000;"
      >
        Hello <?= $agentNameLabel ?>,
      </div>

              </td>
            </tr>

            <tr>
              <td
                 align="left" style="font-size:0px;padding:10px 25px;padding-bottom:10px;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:14px;line-height:24px;text-align:left;color:#000000;"
      >
        Here are your weekly stats from <b><?= $storeNameLabel ?></b>, as well as the percent change from your performance last week.
      </div>

              </td>
            </tr>

      </table>

      </div>

          <!--[if mso | IE]>
            </td>

        </tr>

                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>

      </div>


      <!--[if mso | IE]>
          </td>
        </tr>
      </table>

              </td>
            </tr>

            <tr>
              <td
                 class="" width="600px"
              >

      <table
         align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:598px;" width="598"
      >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->


      <div  style="Margin:0px auto;max-width:598px;">

        <table
           align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"
        >
          <tbody>
            <tr>
              <td
                 style="direction:ltr;font-size:0px;padding:0px;text-align:center;vertical-align:top;"
              >
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">

        <tr>

            <td
               class="" style="vertical-align:top;width:199.33333333333337px;"
            >
          <![endif]-->

      <div
         class="mj-column-per-33 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"
      >

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"
      >
        <tbody>
          <tr>
            <td  style="vertical-align:top;padding-top:20px;padding-bottom:25px;">

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%"
      >

            <tr>
              <td
                 align="center" style="font-size:0px;padding:0;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:14px;line-height:24px;text-align:center;color:#000000;"
      >
      <?php if($revenuePercentage > 0) {  ?>
        <span style='background-color:#d8eacc; display:inline-block; border:5px solid #d8eacc; border-left:10px solid #d8eacc; border-right:10px solid #d8eacc; border-radius:2px;'>
                          +<?=\Yii::$app->formatter->asDecimal($revenuePercentage, 2)?>%
        </span>
      <?php } else {  ?>
        <span style='background-color:#fbcfbd; display:inline-block; border:5px solid #fbcfbd; border-left:10px solid #fbcfbd; border-right:10px solid #fbcfbd; border-radius:2px;'>
                    <?= \Yii::$app->formatter->asDecimal($revenuePercentage, 2)?>%
        </span>
      <?php } ?>

      </div>

              </td>
            </tr>

            <tr>
              <td
                 align="center" style="font-size:0px;padding:0;padding-top:20px;padding-bottom:13px;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:26px;line-height:1em;text-align:center;color:#000000;"
      >
        <?php
          if($thisWeekRevenue > 0)
            echo  '+' . \Yii::$app->formatter->asDecimal($thisWeekRevenue ? $thisWeekRevenue : 0, 3);
          else
            echo   \Yii::$app->formatter->asDecimal($thisWeekRevenue ? $thisWeekRevenue : 0, 3);

         ?>
      </div>

              </td>
            </tr>

            <tr>
              <td
                 align="center" style="font-size:0px;padding:0;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:14px;line-height:24px;text-align:center;color:#6a655f;"
      >
        <?= $store->currency->code ?> Sales Revenue
      </div>

              </td>
            </tr>

      </table>

            </td>
          </tr>
        </tbody>
      </table>

      </div>

          <!--[if mso | IE]>
            </td>

            <td
               class="" style="vertical-align:top;width:199.33333333333337px;"
            >
          <![endif]-->

      <div
         class="mj-column-per-33 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"
      >

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"
      >
        <tbody>
          <tr>
            <td  style="vertical-align:top;padding-top:20px;padding-bottom:25px;">

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%"
      >

            <tr>
              <td
                 align="center" style="font-size:0px;padding:0;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:14px;line-height:24px;text-align:center;color:#000000;"
      >

        <?php if($ordersReceivedPercentage > 0) {  ?>
          <span style='background-color:#d8eacc; display:inline-block; border:5px solid #d8eacc; border-left:10px solid #d8eacc; border-right:10px solid #d8eacc; border-radius:2px;'>
                            +<?=\Yii::$app->formatter->asDecimal($ordersReceivedPercentage, 2)?>%
          </span>
        <?php } else {  ?>
          <span style='background-color:#fbcfbd; display:inline-block; border:5px solid #fbcfbd; border-left:10px solid #fbcfbd; border-right:10px solid #fbcfbd; border-radius:2px;'>
                      <?= \Yii::$app->formatter->asDecimal($ordersReceivedPercentage, 2)?>%
          </span>
        <?php } ?>
      </div>

              </td>
            </tr>

            <tr>
              <td
                 align="center" style="font-size:0px;padding:0;padding-top:20px;padding-bottom:13px;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:26px;line-height:1em;text-align:center;color:#000000;"
      >

        <?php
          if($thisWeekOrdersReceived > 0)
            echo  '+' . $thisWeekOrdersReceived;
          else
            echo '0';
         ?>
      </div>

              </td>
            </tr>

            <tr>
              <td
                 align="center" style="font-size:0px;padding:0;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:14px;line-height:24px;text-align:center;color:#6a655f;"
      >
        Orders
      </div>

              </td>
            </tr>

      </table>

            </td>
          </tr>
        </tbody>
      </table>

      </div>

          <!--[if mso | IE]>
            </td>

            <td
               class="" style="vertical-align:top;width:199.33333333333337px;"
            >
          <![endif]-->

      <div
         class="mj-column-per-33 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"
      >

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"
      >
        <tbody>
          <tr>
            <td  style="vertical-align:top;padding-top:20px;padding-bottom:25px;">

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" style="" width="100%"
      >

            <tr>
              <td
                 align="center" style="font-size:0px;padding:0;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:14px;line-height:24px;text-align:center;color:#000000;"
      >
        <?php if($customerGainedPercentage > 0) {  ?>
          <span style='background-color:#d8eacc; display:inline-block; border:5px solid #d8eacc; border-left:10px solid #d8eacc; border-right:10px solid #d8eacc; border-radius:2px;'>
                            +<?=\Yii::$app->formatter->asDecimal($customerGainedPercentage, 2)?>%
          </span>
        <?php } else {  ?>
          <span style='background-color:#fbcfbd; display:inline-block; border:5px solid #fbcfbd; border-left:10px solid #fbcfbd; border-right:10px solid #fbcfbd; border-radius:2px;'>
                      <?= \Yii::$app->formatter->asDecimal($customerGainedPercentage, 2)?>%
          </span>
        <?php } ?>


      </div>

              </td>
            </tr>

            <tr>
              <td
                 align="center" style="font-size:0px;padding:0;padding-top:20px;padding-bottom:13px;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:26px;line-height:1em;text-align:center;color:#000000;"
      >
        <?php
          if($thisWeekCustomerGained > 0)
            echo  '+' . $thisWeekCustomerGained;
          else
            echo '0';
         ?>
      </div>

              </td>
            </tr>

            <tr>
              <td
                 align="center" style="font-size:0px;padding:0;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:14px;line-height:24px;text-align:center;color:#6a655f;"
      >
        New Customers
      </div>

              </td>
            </tr>

      </table>

            </td>
          </tr>
        </tbody>
      </table>

      </div>

          <!--[if mso | IE]>
            </td>

        </tr>

                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>

      </div>


      <!--[if mso | IE]>
          </td>
        </tr>
      </table>

              </td>
            </tr>

            <tr>
              <td
                 class="" width="600px"
              >

      <table
         align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:598px;" width="598"
      >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->


      <div  style="Margin:0px auto;max-width:598px;">

        <table
           align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"
        >
          <tbody>
            <tr>
              <td
                 style="direction:ltr;font-size:0px;padding:0px;text-align:center;vertical-align:top;"
              >
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">

        <tr>

            <td
               class="" style="vertical-align:top;width:598px;"
            >
          <![endif]-->

      <div
         class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"
      >

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"
      >

            <tr>
              <td
                 align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;padding-top:10px;padding-bottom:20px;word-break:break-word;"
              >

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;"
      >
        <tr>
          <td
             align="center" bgcolor="white" role="presentation" style="border:1px solid #2B546A;border-radius:2px;cursor:auto;padding:10px 25px;background:white;" valign="middle"
          >

            <?=
              Html::a('View more stats', $statsUrl , ['style' => 'background:white;color:#2B546A;font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;line-height:120%;Margin:0;text-decoration:none;text-transform:none;' ,'target' => '_blank'])
            ?>

          </td>
        </tr>
      </table>

              </td>
            </tr>

      </table>

      </div>

          <!--[if mso | IE]>
            </td>

        </tr>

                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>

      </div>


      <!--[if mso | IE]>
          </td>
        </tr>
      </table>

              </td>
            </tr>

            <tr>
              <td
                 class="" width="600px"
              >

      <table
         align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:598px;" width="598"
      >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->


      <div  style="Margin:0px auto;max-width:598px;">

        <table
           align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"
        >
          <tbody>
            <tr>
              <td
                 style="direction:ltr;font-size:0px;padding:0px;padding-bottom:0;padding-top:0;text-align:center;vertical-align:top;"
              >
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">

        <tr>

            <td
               class="" style="vertical-align:top;width:598px;"
            >
          <![endif]-->

      <div
         class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"
      >

      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"
      >

            <tr>
              <td
                 style="font-size:0px;padding:10px 25px;word-break:break-word;"
              >

      <p
         style="border-top:solid 1px #d8e2e7;font-size:1;margin:0px auto;width:100%;"
      >
      </p>

      <!--[if mso | IE]>
        <table
           align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #d8e2e7;font-size:1;margin:0px auto;width:548px;" role="presentation" width="548px"
        >
          <tr>
            <td style="height:0;line-height:0;">
              &nbsp;
            </td>
          </tr>
        </table>
      <![endif]-->


              </td>
            </tr>

            <tr>
              <td
                 align="left" style="font-size:0px;padding:10px 25px;padding-top:10px;padding-bottom:0;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:12px;line-height:24px;text-align:left;color:#6a655f;"
      >
        Don't wish to receive these weekly stats emails?
        <?=
          Html::a('Unsubscribe', $agentProfileUrl , ['style' => 'text-decoration: none; color:#2B546A;' ,'target' => '_blank'])
        ?>
      </div>

              </td>
            </tr>

            <tr>
              <td
                 align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;"
              >

      <div
         style="font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:12px;line-height:24px;text-align:left;color:#000000;"
      >

      </div>

              </td>
            </tr>

      </table>

      </div>

          <!--[if mso | IE]>
            </td>

        </tr>

                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>

      </div>


      <!--[if mso | IE]>
          </td>
        </tr>
      </table>

              </td>
            </tr>

                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>

      </div>


      <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      <![endif]-->


      </div>

      </body>
    </html>
