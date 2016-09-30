<div class="yii-debug-toolbar__block">
    <a href="<?= $panel->getUrl() ?>" title="Switch user panel"><?= $panel->getName() ?> <span
            class="yii-debug-toolbar__label yii-debug-toolbar__label_info">
            <?= Yii::$app->user->isGuest ? 'Guest' : 'ID: ' . Yii::$app->user->id ?>
        </span></a>
</div>