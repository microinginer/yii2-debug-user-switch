<?php
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $panel microinginer\switchUser\SwitchPanel
 * @var $model \yii\db\ActiveRecord
 * @var $switched boolean
 * @var $gridViewColumns array
 */
use yii\widgets\Pjax;

?>
    <p class="alert alert-info">
        <b>Switch</b> - <i>Switches to a new identity for the current user.</i><br>
        <b>Login</b> - <i>Logs in a user.</i>
    </p>
<?php Pjax::begin() ?>
    <div id="success-message"></div>
<?php if ($switched): ?>
    <p class="alert alert-success"><b><?= Yii::t('app', 'User successfully switched. Please refresh a page.') ?></b></p>
<?php endif; ?>
<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => \yii\helpers\ArrayHelper::merge([
        [
            'label' => Yii::t('app', 'Actions'),
            'format' => 'raw',
            'value' => function ($model) use ($panel) {
                return \yii\bootstrap\Html::a(Yii::t('app', 'Switch'), \yii\helpers\Url::to([
                        '/' . $panel->module->id . '/default/view',
                        'panel' => $panel->id,
                        'user_id' => $model->id,
                        'type' => 'switch'
                    ]) . '#success-message') . ' | ' . \yii\bootstrap\Html::a(Yii::t('app', 'Login'), \yii\helpers\Url::to([
                        '/' . $panel->module->id . '/default/view',
                        'panel' => $panel->id,
                        'user_id' => $model->id,
                        'type' => 'login'
                    ]) . '#success-message');
            }
        ],
        'id',
        'username',
    ], $gridViewColumns),
]) ?>
<?php Pjax::end() ?>