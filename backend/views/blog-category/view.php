<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Addon */
/* @var $searchModel backend\models\RestaurantAddonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $category["blogCategoryDescriptions"][0]['title'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="addon-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $category['ID']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $category['ID']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tr>
            <th>Image</th>
            <td><?= Html::encode($category['category_image']) ?></td>
        </tr> 

        <tr>
            <th>Sort number</th>
            <td><?= Html::encode($category['sort_number']) ?></td>
        </tr>
        <tr>
            <th>Slug</th>
            <td><?= Html::encode($category['slug']) ?></td>
        </tr>
    </table>

    <?php foreach ($category['blogCategoryDescriptions'] as $blogCategoryDescription) { ?>

    <h3><?= Html::encode($blogCategoryDescription["language_code"]) ?></h3>

    <table class="table table-striped table-bordered detail-view">
        <tr>
            <th>Title</th>
            <td><?= Html::encode($blogCategoryDescription['title']) ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?= Html::encode($blogCategoryDescription['description']) ?></td>
        </tr>
    </table>
    <?php } ?>
</div>
