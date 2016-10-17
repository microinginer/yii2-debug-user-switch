<?php


namespace microinginer\switchUser;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\debug\Panel;
use yii\web\IdentityInterface;

/**
 * Yii2 debug user
 * */
class SwitchPanel extends Panel
{
    public $queryCondition;

    public $gridViewColumns = [];

    public $modelClass = 'app\models\User';

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'User';
    }

    public function init()
    {
        if ($this->queryCondition && !($this->queryCondition instanceof \Closure)) {
            throw new \Exception("Condition must be closure");
        }
    }

    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        return Yii::$app->view->render('@vendor/microinginer/yii2-debug-user-switch/src/views/summary', ['panel' => $this]);
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidCallException
     * @throws \yii\base\ViewNotFoundException
     */
    public function getDetail()
    {
        /**
         * @var $model ActiveRecord
         */
        $model = new $this->modelClass;

        $model->load(Yii::$app->request->get());
        $query = $model::find();

        if ($this->queryCondition) {
            $condition = $this->queryCondition;
            $condition($query, $model);
        }
        $query->andFilterWhere(['like', 'username', $model->username]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $switched = false;

        if (Yii::$app->request->get('user_id')) {
            if (Yii::$app->request->get('type') === 'login') {
                $switched = $this->loginUser(Yii::$app->request->get('user_id'));
            } else {
                $switched = $this->switchUser(Yii::$app->request->get('user_id'));
            }
        }

        return Yii::$app->view->render('@vendor/microinginer/yii2-debug-user-switch/src/views/detail', [
            'dataProvider' => $dataProvider,
            'panel' => $this,
            'model' => $model,
            'switched' => $switched,
            'gridViewColumns' => $this->gridViewColumns,
        ]);
    }


    public function switchUser($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne($id);

        if (!$model) {
            return false;
        }

        Yii::$app->getUser()->switchIdentity($model, 0);

        return true;
    }

    public function loginUser($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne($id);

        if (!$model) {
            return false;
        }

        return Yii::$app->getUser()->login($model, 0);
    }
}