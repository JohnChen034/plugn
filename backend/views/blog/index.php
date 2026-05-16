<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success btn-create']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php foreach ($posts as $post) { ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3 class="panel-title">
                <?= Html::encode(isset($post['blogPostDescriptions'][0]) ? $post['blogPostDescriptions'][0]['title'] : "Post #" . $post["ID"]) ?>
            </h3>

            <br />

            <?= Html::a('View', ['blog/view', 'id' => $post['ID']], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php } ?>

    <!-- todo: pagination -->

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li>
                <a href="<?= Url::to(['blog/index', 'page' => 1]) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li <?php if($i == $page) echo 'class="active"'; ?>>
                <a href="<?= Url::to(['blog/index', 'page' => $i]) ?>"><?= $i ?></a>
            </li>
            <?php } ?>
            <li>
                <a href="<?= Url::to(['blog/index', 'page' => $total_pages]) ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>


</div>
