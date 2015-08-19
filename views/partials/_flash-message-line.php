<?php
/**
 * @var app\components\View $this
 */
?>

<div id="messages_wrapper">
    <?php if($this->hasFlash('stats_status_flash')): ?>
        <div class="alert alert-danger" role="alert">
            <?= $this->getFlash('stats_status_flash') ?>
        </div>
    <?php endif; ?>
</div>

