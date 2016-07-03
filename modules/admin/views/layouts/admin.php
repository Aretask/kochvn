<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$this->title = 'Общие настройки';
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <script src="/css/admin.css"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Кочевник',
        'brandUrl' => '/',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Общие настройки', 'url' => ['/admin/default/main/']],
            ['label' => 'Настройка фильтров', 'url' => ['/admin/different/filter']],
            ['label' => 'Настройка категорий', 'url' => ['/admin/different/category']],
            ['label' => 'Производитель', 'url' => ['/admin/different/course']],
            ['label' => 'Заказы', 'items' => [
                    ['label' => 'Список заказов', 'url' => ['/admin/orders/orders/']],
                    ['label' => 'Покупатели', 'url' => ['/admin/orders/buyers/']],
                ]],
            ['label' => 'Товар', 'items' => [
                    ['label' => 'Список товара', 'url' => ['/admin/products/list/']],
                    ['label' => 'Добавить товар', 'url' => ['/admin/products/add/']],
                    ['label' => 'Распарсить фаил', 'url' => ['/admin/parse/parse/']],
                    ['label' => 'Список распаресенного товара', 'url' => ['/admin/parse/list-parse/']],
                ]],
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/admin/']] :
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/admin/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Кочевник <?= date('Y') ?></p>

    </div>
</footer>

<?php $this->endBody() ?>
      <script src="/js/admin.js"></script>
</body>
</html>
<?php $this->endPage() ?>
