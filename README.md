yii2-debug-user-switch
=================================

This extension for yii2-debug. Use only development environment.

Install
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist microinginer/yii2-debug-user-switch:"dev-master"
```

or add

```json
"microinginer/yii2-debug-user-switch":"dev-master"
```
to the require section of your composer.json file.


Configuration
---------------

```php
// config/web.php

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        ...
        'panels' => [
            'switchUser' => [
                'class' => 'microinginer\switchUser\SwitchPanel',
                'modelClass' => '\app\models\User',
                /*
                'queryCondition' => function (\yii\db\ActiveQuery &$query, \yii\db\ActiveRecord $model) {
                    $query->andWhere('suborg_id IS NOT NULL');
                },
                'gridViewColumns' => [
                    'full_name',
                    [
                        'attribute' => 'org.name',
                        'label' => 'Organization',
                    ],
                    [
                        'label' => Yii::t('app', 'Roles'),
                        'value' => function ($model) {
                            $roles = '';
                            foreach (Yii::$app->authManager->getRolesByUser($model->id) as $role) {
                                $roles .= ', ' . $role->name;
                            }
                            $roles = substr($roles, 1);
                            return $roles;
                        }
                    ],
                ],
                */
            ]
        ],
        ...
    ];
}

```
