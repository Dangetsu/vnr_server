<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use yii\data\ActiveDataProvider;
use yii\filters\auth;
use yii\rest;
use app\modules\v2\models;
use yii\db;

abstract class BaseController extends rest\ActiveController {

    const PUT_METHOD = 'PUT';
    const FILTER_FIELD = 'filter';

    /**
     * @var string
     */
    public $modelClass;

    /**
     * @return array
     */
    public function actions() {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = function($action) {
            /**
             * @var \yii\db\ActiveRecord $modelClass
             */
            $modelClass = $action->modelClass;
            $filterParams = array_key_exists(self::FILTER_FIELD, \Yii::$app->request->queryParams) ? \Yii::$app->request->queryParams[self::FILTER_FIELD] : [];
            $searchParams = [];
            if (count($filterParams) > 0) {
                $columnNames = $modelClass::getTableSchema()->getColumnNames();
                foreach ($filterParams as $key => $value) {
                    if (array_search($key, $columnNames) !== false) {
                        $searchParams[$key] = $value;
                    }
                }
            }
            return new ActiveDataProvider([
                'query' => $modelClass::find()->where($searchParams),
            ]);
        };
        return $actions;
    }

    /**
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => auth\HttpBasicAuth::className(),
            'only' => [],
            'auth' => function ($username, $password) {
                return models\User::findOne([
                    'name' => $username,
                    'password' => $this->_generatePasswordHash($password),
                ]);
            },
        ];
        return $behaviors;
    }

    /**
     * @param string $password
     * @return string
     */
    protected function _generatePasswordHash($password) {
        return md5(md5($password));
    }

    /**
     * @param db\ActiveRecord $model
     * @param array $params
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    protected function _saveModel(db\ActiveRecord $model, array $params = []) {
        if (count($params) === 0) {
            $params = \Yii::$app->getRequest()->getBodyParams();
        }
        $model->load($params, '');
        $isSave = $model->save();
        if ($isSave === false && !$model->hasErrors()) {
            throw new \yii\web\ServerErrorHttpException('Failed to save the object for unknown reason.');
        }
    }
}