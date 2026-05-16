<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantDomainRequest */

$this->title = $model->request_uuid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Restaurant Domain Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


\yii\web\YiiAsset::register($this);
?>
<div class="restaurant-domain-request-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->request_uuid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->request_uuid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php

    // if custom domain + status assigned + site not published

    if
    (
        !str_contains($model->restaurant->restaurant_domain, ".plugn.site") &&
        !str_contains($model->restaurant->restaurant_domain, ".plugn.store")
    )  {

        if ($model->restaurant->site_id) {
            $siteId = rawurlencode($model->restaurant->site_id);
            ?>
            <br />
            <p>Build status: <img src="https://api.netlify.com/api/v1/badges/<?= Html::encode($siteId) ?>/deploy-status" />
            </p>
            <br />

            <?php
            $response = Yii::$app->netlifyComponent->getSiteDns($model->restaurant->site_id);

            if (isset($response->data['message'])) {
                echo "<p class='alert alert-danger'>Error from netlify: " . Html::encode($response->data['message']) . "</p>";
            } else if (sizeof($response->data) > 0) {
                $arr = $response->data[sizeof($response->data) - 1];

                $dnsServers = array_map([Html::class, 'encode'], $arr['dns_servers']);

                echo "<p>DNS Servers: " . implode(", ", $dnsServers) . "</p>";

                $hostnames = \yii\helpers\ArrayHelper::getColumn($arr['records'], "hostname");
                $hostnames = array_map([Html::class, 'encode'], $hostnames);

                echo "<p>Hostnames: " . implode(", ", $hostnames) . "</p>";
            } else { ?>
                <p class='alert alert-warning'>Nameservers not available/ configured</p>
                <!--
                <p class='alert alert-warning'>
                    Nameservers to update in domain registrar: Ask tech team to set up domain in netlify and provide list of name servers.
                    </p>

                <p><?= Html::a(Yii::t('app', 'Configure DNS'), [
                    'restaurant/configure-dns', 'id' => $model->restaurant_uuid], ['class' => 'btn btn-primary']) ?> </p>
                -->
            <?php } ?>

            <ion-card>
                <ion-card-header>
                    <ion-card-title>
                        <h2>Changed need to be done for custom domain </h2>
                    </ion-card-title>
                </ion-card-header>
                <ion-card-content dir="ltr">
                    <!--
                    <div class="alert alert-info" role="status">
                      <p>This domain is waiting for External DNS propagation (that can take up to 24 hours) or has not been configured properly.
                        Confirm you have configured this domain properly with the suggestions below or check out the
                        <a target="_blank" rel="noopener" href="https://docs.netlify.com/domains-https/custom-domains/configure-external-dns/">documentation</a>.
                      </p>
                    </div>-->

                    <h2><b>Recommended:</b><br>Point ALIAS, ANAME, or flattened CNAME record to apex-loadbalancer.netlify.com</h2>

                    <p>If your <a target="_blank" rel="noopener" href="https://answers.netlify.com/t/support-guide-which-are-some-good-dns-providers-for-alias-aname-support/211">DNS provider supports ALIAS, ANAME, or flattened CNAME records</a>,
                        use this recommended configuration, which is more resilient than the fallback option.</p>

                    <p>Create an ALIAS, ANAME, or flattened CNAME record for YOUR.DOMAIN pointing to our load balancer at apex-loadbalancer.netlify.com.</p>

                    <pre class="tw-mx-0 tw-my-3 tw-bg-black tw-text-white tw-antialiased">YOUR.DOMAIN ALIAS apex-loadbalancer.netlify.com</pre>

                    <h2><b>Fallback:</b><br>Point A record to 75.2.60.5</h2>

                    <p>If your DNS provider does not support ALIAS, ANAME, or flattened CNAME records, use this fallback option.</p>

                    <p>Create an A record for YOUR.DOMAIN pointing to our load balancer’s IP address 75.2.60.5.</p>

                    <pre class="tw-mx-0 tw-my-3 tw-bg-black tw-text-white tw-antialiased">YOUR.DOMAIN A 75.2.60.5</pre>

                </ion-card-content>
            </ion-card>

        <?php } else { ?>
            <p> Publish site to netlify to have ssl certificate and custom domain </p>
            <p>
                <?= Html::a(Yii::t('app', 'Publish to netlify'), [
                    'restaurant/publish', 'id' => $model->restaurant_uuid], ['class' => 'btn btn-primary']) ?>
            </p>
        <?php
        }
    } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'request_uuid',
            'storeName',
            'domain',
            [
                    'attribute' => 'status',
                'value' => function($data) {
                    return \common\models\RestaurantDomainRequest::arrStatus()[$data->status];
                }
            ],
            'created_by',
            'expire_at:date',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
