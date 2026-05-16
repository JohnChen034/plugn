
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\DashboardAsset;
use common\widgets\Alert;
use common\models\Restaurant;
use common\models\AgentAssignment;
use yii\helpers\Url;

DashboardAsset::register($this);

$restaurant = Restaurant::find()->where(['restaurant_uuid' => $this->params['restaurant_uuid']])->one();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!-- <html class="loading" lang="en" data-textdirection="ltr"> -->
<html lang="<?= Yii::$app->language ?>">
    <!-- BEGIN: Head-->

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title>
            <?= Html::encode($this->title) ?>
        </title>
        <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />


        <?php $this->head() ?>

        <!-- Hotjar Tracking Code for Plugn - Old dashboard -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2120272,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>


    </head>

    <!-- END: Head-->


    <!-- BEGIN: Body-->

    <body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
        <?php $this->beginBody() ?>

        <!-- BEGIN: Header-->
        <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
            <div class="navbar-wrapper">
                <div class="navbar-container content">
                    <div class="navbar-collapse" id="navbar-mobile">
                        <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                            <ul class="nav navbar-nav">
                                <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                            </ul>
                            <ul class="nav navbar-nav float-left">
                            </ul>

                        </div>



                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                    <div class="user-nav d-sm-flex d-none">
                                        <span class="user-name text-bold-600">
                                            <?= Html::tag('span', Yii::$app->user->identity->agent_name, ['agent/index', 'storeUuid' => $this->params['restaurant_uuid']]) ?>
                                        </span>
                                    </div>
                                    <span>
                                        <img src="<?= Yii::$app->urlManager->getBaseUrl() . '/img/avatar.jpg' ?>" class="round"  alt="avatar" height="40" width="40">
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">

                                    <?=
                                    Html::a(
                                            '<i class="feather icon-user"></i> Edit Profile', ['agent/update', 'storeUuid' => $this->params['restaurant_uuid']], ['class' => 'dropdown-item'])
                                    ?>

                                    <div class="dropdown-divider"> </div>

                                    <?=
                                    Html::a(
                                            '<i class="feather icon-lock"></i> Change Password', ['agent/change-password', 'storeUuid' => $this->params['restaurant_uuid']], ['class' => 'dropdown-item'])
                                    ?>

                                    <div class="dropdown-divider"> </div>

                                    <?=
                                    Html::a('<i class="feather icon-power"></i> Logout', ['site/logout'], ['class' => 'dropdown-item',
                                        'data' => [
                                            'method' => 'post',
                                        ]
                                    ])
                                    ?>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </nav>
        <ul class="main-search-list-defaultlist-other-list d-none">
            <li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100 py-50">
                    <div class="d-flex justify-content-start"><span class="mr-75 feather icon-alert-circle"></span><span>No results found.</span></div>
                </a></li>
        </ul>
        <!-- END: Header-->


        <!-- BEGIN: Main Menu-->

        <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mr-auto">
                        <?=
                           Html::a(
                               Html::img($restaurant->getRestaurantLogoUrl(), [
                                   'class' => 'round',
                                   'height' => 40,
                                   'width' => 40,
                                   'alt' => $restaurant->name,
                               ]) .
                               Html::tag(
                                   'h2',
                                   Html::encode($restaurant->name),
                                   [
                                       'class' => 'brand-text mb-0',
                                       'style' => 'font-size: 20px; width: 190px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;',
                                   ]
                               ),
                               ['site/index', 'id' => $restaurant->restaurant_uuid],
                               ['class' => 'navbar-brand']
                           );
                        ?>
                    </li>
                    </a>
                    </li>
                </ul>
            </div>
            <div class="shadow-bottom"></div>
            <div class="main-menu-content">



                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


                    <?php if (Yii::$app->user->identity->isOwner($restaurant->restaurant_uuid)) { ?>

                        <li class=" nav-item <?= $this->context->route == 'site/vendor-dashboard' ? 'active' : '' ?> ">

                            <?=
                            Html::a(
                                    Html::tag('i', '', ['class' => ' feather icon-home']) .
                                    Html::tag('span', 'Dashboard'), ['site/vendor-dashboard', 'id' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                            )
                            ?>
                        </li>
                    <?php } ?>


                    <li  <?= $this->context->route == 'site/real-time-orders' ? 'class="active"' : '' ?>>
                        <?=
                        Html::a(
                                Html::tag('i', '', ['class' => 'feather icon-server']) .
                                Html::tag('span', 'Real Time Orders'), ['site/real-time-orders', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-item']
                        )
                        ?>
                    </li>


                    <li class=" nav-item">
                        <a>
                            <i class="feather icon-shopping-cart"></i>
                            <span class="menu-title">Orders</span>
                        </a>
                        <ul class="menu-content" style="    padding-left: 17px;">

                            <li  <?= $this->context->route == 'order/index' ? 'class="active"' : '' ?>>
                                <?=
                                Html::a(
                                        Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                        Html::tag('span', 'All Orders'), ['order/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-item']
                                )
                                ?>
                            </li>
                            <li  <?= $this->context->route == 'order/draft' ? 'class="active"' : '' ?>>
                                <?=
                                Html::a(
                                        Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                        Html::tag('span', 'Drafts'), ['order/draft', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-item']
                                )
                                ?>
                            </li>
                            <li  <?= $this->context->route == 'order/abandoned-checkout' ? 'class="active"' : '' ?>>
                                <?=
                                Html::a(
                                        Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                        Html::tag('span', 'Abandoned checkouts'), ['order/abandoned-checkout', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-item']
                                )
                                ?>
                            </li>
                        </ul>
                    </li>

                    <li class=" nav-item <?= $this->context->route == 'category/index' ? 'active' : '' ?> ">

                        <?=
                        Html::a(
                                Html::tag('i', '', ['class' => 'feather icon-grid']) .
                                Html::tag('span', 'Categories'), ['category/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                        )
                        ?>
                    </li>
                    <li class=" nav-item">
                        <a>
                            <i class="fa fa-cubes"></i>
                            <span class="menu-title">Items</span>
                        </a>
                        <ul class="menu-content" style="    padding-left: 17px;">

                            <li  <?= $this->context->route == 'item/index' ? 'class="active"' : '' ?>>
                                <?=
                                Html::a(
                                        Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                        Html::tag('span', 'All Items'), ['item/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                )
                                ?>
                            </li>


                            <li  <?= $this->context->route == 'item/inventory' ? 'class="active"' : '' ?>>
                                <?=
                                Html::a(
                                        Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                        Html::tag('span', 'Inventory'), ['item/inventory', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                )
                                ?>
                            </li>

                        </ul>
                    </li>


                    <?php if($restaurant->country_id = 84 && $restaurant->is_tap_enable) { ?>

                    <li class=" nav-item">
                        <a>
                            <i class="fa  fa-tags"></i>
                            <span class="menu-title">Discounts</span>
                        </a>
                        <ul class="menu-content" style="padding-left: 17px;">
                            <li  <?= $this->context->route == 'voucher/index' ? 'class="active"' : '' ?>>
                                <?=
                                Html::a(
                                        Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                        Html::tag('span', 'Voucher'), ['voucher/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-item']
                                )
                                ?>
                            </li>

                            <li  <?= $this->context->route == 'bank-discount/index' ? 'class="active"' : '' ?>>
                                <?=
                                Html::a(
                                        Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                        Html::tag('span', 'Bank Discount'), ['bank-discount/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-item']
                                )
                                ?>
                            </li>

                        </ul>
                    </li>
                  <?php } else { ?>
                    <li  <?= $this->context->route == 'voucher/index' ? 'class="active"' : '' ?>>
                        <?=
                        Html::a(
                                Html::tag('i', '', ['class' =>  'fa  fa-tags']) .
                                Html::tag('span', 'Voucher'), ['voucher/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-item']
                        )
                        ?>
                    </li>
                  <?php } ?>


                    <li class=" nav-item <?= $this->context->route == 'customer/index' ? 'active' : '' ?> ">

                        <?=
                        Html::a(
                                Html::tag('i', '', ['class' => 'feather icon-user']) .
                                Html::tag('span', 'Customers'), ['customer/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                        )
                        ?>
                    </li>
                    <?php if (Yii::$app->user->identity->isOwner($restaurant->restaurant_uuid)) { ?>

                        <li class=" nav-item">
                            <a>
                                <i class="fa fa-signal"></i>
                                <span class="menu-title">Analytics</span>
                            </a>
                            <ul class="menu-content" style="padding-left: 17px;">
                              <li class=" nav-item <?= $this->context->route == 'store/statistics' ? 'active' : '' ?> ">

                                  <?=
                                  Html::a(
                                    Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                          Html::tag('span', 'Statistics'), ['store/statistics', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                  )
                                  ?>
                              </li>
                              <li class=" nav-item <?= $this->context->route == 'store/reports' ? 'active' : '' ?> ">

                                  <?=
                                  Html::a(
                                    Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                          Html::tag('span', 'Reports'), ['store/reports', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                  )
                                  ?>
                              </li>

                            </ul>
                        </li>



                    <?php } ?>


                    <li class=" nav-item">
                        <a>
                            <i class="feather icon-settings"></i>
                            <span class="menu-title">Settings</span>
                        </a>
                        <ul class="menu-content" style="padding-left: 17px;">
                            <?php if (Yii::$app->user->identity->isOwner($restaurant->restaurant_uuid)) { ?>

                                <li class=" nav-item <?= $this->context->route == 'store/update' || $this->context->route == 'store/update' ? 'active' : '' ?> ">
                                    <?=
                                    Html::a(
                                            Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                            Html::tag('span', 'Store Info'), ['store/update', 'id' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                    )
                                    ?>
                                </li>

                                <li class=" nav-item <?= $this->context->route == 'store/view-payment-methods'  ? 'active' : '' ?> ">
                                    <?=
                                    Html::a(
                                            Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                            Html::tag('span', 'Payment Methods'), ['store/view-payment-methods', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                    )
                                    ?>
                                </li>

                              <?php if ($restaurant->version == 2 || $restaurant->version == 3 || $restaurant->version == 4) { ?>

                                <li class=" nav-item <?= $this->context->route == 'business-location/index'  ? 'active' : '' ?> ">
                                    <?=
                                    Html::a(
                                            Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                            Html::tag('span', 'Business Locations'), ['business-location/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                    )
                                    ?>
                                </li>
                              <?php }  ?>

                              <?php if ($restaurant->has_deployed) { ?>
                                <li class=" nav-item <?= $this->context->route == 'site/domains'  ? 'active' : '' ?> ">
                                    <?=
                                    Html::a(
                                            Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                            Html::tag('span', 'Domains'), ['site/connect-domain', 'id' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                    )
                                    ?>
                                </li>
                              <?php }  ?>

                                <li class=" nav-item <?= $this->context->route == 'store/view-design-layout' || $this->context->route == 'store/update-design-layout' ? 'active' : '' ?> ">
                                    <?=
                                    Html::a(
                                            Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                            Html::tag('span', 'Design & layout'), ['store/update-design-layout', 'id' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                    )
                                    ?>
                                </li>
                                <li class=" nav-item <?= $this->context->route == 'web-link/index' || $this->context->route == 'web-link/create' ? 'active' : '' ?> ">
                                    <?=
                                    Html::a(
                                            Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                            Html::tag('span', 'Web Links'), ['web-link/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                    )
                                    ?>
                                </li>

                                <li class=" nav-item">
                                    <a>
                                        <i class="feather icon-circle"></i>
                                        <span class="menu-title">Integrations</span>
                                    </a>
                                    <ul class="menu-content" style=" padding-left: 27px;">
                                        <li  <?= $this->context->route == 'store/update-analytics-integration' ? 'class="active"' : '' ?>>
                                            <?=
                                            Html::a(
                                                    Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                                    Html::tag('span', 'Analytics'), ['store/update-analytics-integration', 'id' => $restaurant->restaurant_uuid], ['class' => 'menu-item']
                                            )
                                            ?>
                                        </li>
                                    </ul>
                                </li>

                            <?php } ?>

                            <li class=" nav-item <?= $this->context->route == 'opening-hour/index' ? 'active' : '' ?> ">
                                <?=
                                Html::a(
                                        Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                        Html::tag('span', 'Opening Hours'), ['opening-hour/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                )
                                ?>
                            </li>
                            <?php if (Yii::$app->user->identity->isOwner($restaurant->restaurant_uuid)) { ?>
                                <li class=" nav-item <?= $this->context->route == 'agent-assignment/index' ? 'active' : '' ?> ">

                                    <?=
                                    Html::a(
                                            Html::tag('i', '', ['class' => 'feather icon-circle']) .
                                            Html::tag('span', 'Staff Management'), ['agent-assignment/index', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title']
                                    )
                                    ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>

                    <li class=" nav-item">

                        <?=
                        Html::a(
                                Html::tag('i', '', ['class' => 'feather icon-layout']) .
                                Html::tag('span', 'Try the new Plugn'), 'https://dash.plugn.io/?utm_source=old-dashboard&utm_medium=poweredbylink', ['class' => 'menu-title', 'target'=>'_blank']
                        )
                        ?>
                    </li>


                    <li class=" nav-item">

                        <?=
                        Html::a(
                                Html::tag('i', '', ['class' => 'feather icon-eye']) .
                                Html::tag('span', 'Visit Store'), ['site/redirect-to-store-domain', 'storeUuid' => $restaurant->restaurant_uuid], ['class' => 'menu-title', 'style' => 'border: 2px solid #28c76f; border-radius: 5px;']
                        )
                        ?>
                    </li>

                    <?php if (count(Yii::$app->accountManager->getManagedAccounts()) > 1) { ?>
                        <li class=" navigation-header"><span>Your stores</span>

                            <?php
                            foreach (Yii::$app->accountManager->getManagedAccounts() as $managedRestaurant) {
                                if ($managedRestaurant->restaurant_uuid != $this->params['restaurant_uuid']) {
                                    ?>
                                <li class=" nav-item">

                                    <?=
                                    Html::a(
                                            Html::img($managedRestaurant->restaurant->getRestaurantLogoUrl(), ['class' => 'round', 'style' => 'opacity: .8; margin-right: .5rem; margin-top: -3px; max-height: 33px; width: auto;']) .
                                            Html::tag('span', $managedRestaurant->restaurant->name), ['site/vendor-dashboard', 'id' => $managedRestaurant->restaurant_uuid], ['class' => 'menu-title']
                                    )
                                    ?>
                                </li>
                                <?php
                            }
                        }
                    }
                    ?>

                </ul>

            </div>
        </div>
        <!-- END: Main Menu-->

        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <h2 class="content-header-title float-left mb-0"><?= $this->title ?></h2>
                                <div class="breadcrumb-wrapper col-12">
                                    <?=
                                    Breadcrumbs::widget([
                                        'homeLink' => [
                                            'label' => Yii::t('yii', 'Dashboard'),
                                            'url' => ['site/index', 'id' => $this->params['restaurant_uuid']],
                                        ],
                                        'itemTemplate' => "<li class='breadcrumb-item'><i>{link}</i></li>\n", // template for all links
                                        'activeItemTemplate' => "<li class='breadcrumb-item'><i>{link}</i></li>\n", // template for all links
                                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                        'options' => ['class' => 'breadcrumb']
                                    ])
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">

                    <!-- todo: move flash messages here -->

                    <div class="alert alert-warning" role="alert">
                        <b>Important:</b>

                        <p>This is deprecated version of plugn dashboard, please use new dashboard for uninterrupted service. </p>

                        <?=
                        Html::a(
                            Html::tag('span', 'Try the new Plugn'), 'https://dash.plugn.io/?utm_source=old-dashboard&utm_medium=poweredbylink', ['class' => 'menu-title', 'target'=>'_blank']
                        )
                        ?>

                    </div>

                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->


    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021<a class="text-bold-800 grey darken-2" href="https://plugn.io/" target="_blank">Plugn,</a>All rights Reserved</span><span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i class="feather icon-heart pink"></i></span>
        </p>
    </footer>
    <!-- END: Footer-->

    <?php

      $segmentScript = '';
      $storeConversionParams = '';

      if(Yii::$app->user->identity){

        $full_name = explode(' ', Yii::$app->user->identity->agent_name);

        $storeName = $restaurant->name;
        $ownerPhoneNumber = $restaurant->owner_number;
        $agentEmail = Yii::$app->user->identity->agent_email;

        $planName = $restaurant->plan? $restaurant->plan->name: 'Free plan';

        $tapAccountCreated = $restaurant->is_tap_enable ? 'yes' : 'no';
        $paymentCash = $restaurant->getPaymentMethods()->where(['payment_method_id' => 3])->exists() ? 'yes' : 'no';
        $paymentKNET = $restaurant->getPaymentMethods()->where(['payment_method_id' => 1])->exists() ? 'yes' : 'no';
        $paymentCreditcard = $restaurant->getPaymentMethods()->where(['payment_method_id' => 2])->exists() ? 'yes' : 'no';
        $deliveryMashkor = $restaurant->mashkor_branch_id ? 'yes' : 'no' ;
        $deliveryArmada = $restaurant->armada_api_key ? 'yes' : 'no' ;
        $storeLogo = $restaurant->logo ? $restaurant->getRestaurantLogoUrl() : 'false';

        $segmentScript = "analytics.identify('". $restaurant->restaurant_uuid."', {
            newDashboard: false,
            name: '". $storeName ."',
            domain:'". $restaurant->restaurant_domain  ."',
            phone:'". $ownerPhoneNumber  ."',
            email: '".$agentEmail  ."',
            plan: '". $planName ."',
            logo: '". $storeLogo ."',
            totalProducts: '". $restaurant->getItems()->count() ."',
            totalOrders: '". $restaurant->getOrders()->count() ."',
            tapAccountCreated: '". $tapAccountCreated ."',
            paymentCash: '". $paymentCash ."',
            paymentKNET: '". $paymentKNET ."',
            paymentCreditcard: '". $paymentCreditcard ."',
            paymentMada: 'no',
            deliveryMashkor: '".  $deliveryMashkor ."',
            deliveryArmada: '".  $deliveryArmada ."',
          });
       ";

           if( Yii::$app->session->getFlash('storeCreated')){
             $storeConversionParams  = "analytics.track('Store Conversion',{});";
           }

        } ?>



    <script>
      !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on","addSourceMiddleware","addIntegrationMiddleware","setAnonymousId","addDestinationMiddleware"];analytics.factory=function(e){return function(){var t=Array.prototype.slice.call(arguments);t.unshift(e);analytics.push(t);return analytics}};for(var e=0;e<analytics.methods.length;e++){var key=analytics.methods[e];analytics[key]=analytics.factory(key)}analytics.load=function(key,e){var t=document.createElement("script");t.type="text/javascript";t.async=!0;t.src="https://cdn.segment.com/analytics.js/v1/" + key + "/analytics.min.js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(t,n);analytics._loadOptions=e};analytics.SNIPPET_VERSION="4.13.1";
      analytics.load("2b6WC3d2RevgNFJr9DGumGH5lDRhFOv5");
      <?= $segmentScript ?>
      analytics.page();
      <?=  $storeConversionParams ?>
      }}();
    </script>

    <?php $this->endBody() ?>


</body>
<!-- END: Body-->

</html>
<?php $this->endPage() ?>
