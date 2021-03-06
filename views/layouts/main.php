<?php
/**
 * @var \app\components\View $this
 * @var string $content
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php
    $user = Yii::$app->user;
    $menu = [
        ['label' => $this->t('Products'), 'url' => ['/product/list']],
        ['label' => $this->t('Recipes'), 'url' => ['/recipe/list']],
        ['label' => $this->t('Portions'), 'url' => ['/portion/list']],
        ['label' => $this->t('Trainings'), 'url' => ['/training/list']],
    ];

    if ($user->isGuest) {
        $menu[] = ['label' => $this->t('Login'), 'url' => ['/index/login']];
        $menu[] = ['label' => $this->t('Registration'), 'url' => ['/index/registration']];
    } else {
        $menu[] = ['label' => $this->t('Diary'), 'url' => ['/diary/list']];
        $menu[] = ['label' => $this->t('Week stats'), 'url' => ['/week-stats/list']];
        //$menu[] = ['label' => $this->t('Plans'), 'url' => ['/plan/list']];
        //$menu[] = ['label' => $this->t('Menus'), 'url' => ['/menu/list']];
        $menu[] = [
            'label' => $user->name,
            'items' => [
                ['label' => $this->t('Account'), 'url' => ['/account/view']],
                ['label' => $this->t('Logout'), 'url' => ['/index/logout'], 'linkOptions' => ['data-method' => 'post']],
            ],
        ];
    }
?>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => $this->t('Calories Calc'),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menu,
            ]);
            NavBar::end();
        ?>

        <div class="container">

            <?= $this->render('@app/views/partials/_flash-message-line') ?>

            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= $this->t('Calories Calc') ?> <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>


<?php $this->registerJs('
    Main.init({
        language: \''. Yii::$app->language .'\',
        dateFormat: \''. $this->getFrontendDateFormat() .'\'
    });
', $this::POS_END); ?>

<?php $this->registerJs('
    Router.init({
        rules: '.$this->getRules().'
    });
', $this::POS_END); ?>

<?php $this->registerJs('
    Api.init();
', $this::POS_END); ?>

<?php $this->endBody() ?>



</body>
</html>
<?php $this->endPage() ?>
