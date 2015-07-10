<?php
/**
 * @var app\components\View $this
 * @var array $ingredients
 * @var string $url
 */

use yii\helpers\Html;
?>

<?php
    $calories = 0;
    $weight = 0;
    $str = '';
?>
<td>
    <?php foreach($ingredients as $ingredient): ?>
        <?php
            $ingredientCount = isset($ingredient['count']);
        ?>
        <?php $str .= $ingredientCount ? $ingredient['count'] . ' ' : '' ?>
        <?php $str .= Html::a($ingredient['name'], [$url, 'id' => $ingredient['id']]) . ' ' ?>
        <?php $str .= '(' ?>
        <?php $str .= $this->round($ingredient['calories'], 0) . $this->t('cc.') . ', ' ?>
        <?php $str .= $this->round($ingredient['weight'], 0) . $this->t('gr.') ?>
        <?php $str .= ')' ?>
        <?php $calories += isset($ingredient['calories']) ? $ingredient['calories'] : 0 ?>
        <?php $weight += isset($ingredient['weight']) ? $ingredient['weight'] : 0 ?>
        <?php $str .= ', ' ?>
    <?php endforeach ?>
    <?= substr($str, 0, strlen($str) - 2) ?>
</td>
<td>
    <?= $calories > 0 ? $this->round($calories, 0) . $this->t('cc.') : '' ?><?= $calories > 0 && $weight > 0 ? ', ' : '' ?>
    <?= $weight > 0 ? $this->round($weight, 0) . $this->t('gr.') : '' ?>
</td>

