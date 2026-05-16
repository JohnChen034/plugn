<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog categories';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="city-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success btn-create']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php foreach ($categories as $category) { ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3 class="panel-title">
                <?= Html::encode(isset($category['blogCategoryDescriptions'][0]) ? $category['blogCategoryDescriptions'][0]['title'] : "Category #" . $category["ID"]) ?>
            </h3>

            <br />

            <?= Html::a('View', ['blog-category/view', 'id' => $category['ID']], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php } ?>


</div>
