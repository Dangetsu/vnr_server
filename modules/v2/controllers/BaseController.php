<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use yii\base;
use yii\data\ActiveDataProvider;
use yii\filters\auth;
use yii\rest;
use app\modules\v2\models;
use yii\db;
use yii\web;

abstract class BaseController extends rest\ActiveController {

    const PUT_METHOD = 'PUT';
    const FILTER_FIELD = 'filter';
    const LIMIT_PER_PAGE = 1000;

    const ACTION_INDEX = 'index';
    const ACTION_VIEW = 'view';
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    /** @var string */
    public $modelClass;

    /** @var array */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * @return array
     */
    public function actions() {
        $actions = parent::actions();
        $actions[self::ACTION_INDEX]['prepareDataProvider'] = function(rest\Action $action) {
            return new ActiveDataProvider([
                'query' => $this->_getActiveQuery($action->modelClass),
                'pagination' => [
                    'pageSizeLimit' => [1, self::LIMIT_PER_PAGE]
                ]
            ]);
        };
        unset($actions[self::ACTION_DELETE], $actions[self::ACTION_CREATE], $actions[self::ACTION_UPDATE]);
        return $actions;
    }

    /**
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => auth\HttpBasicAuth::className(),
            'optional' => [self::ACTION_INDEX, self::ACTION_VIEW],
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
     * @return db\ActiveRecord
     * @throws base\InvalidConfigException
     * @throws web\ServerErrorHttpException
     */
    public function actionCreate() {
        /** @var db\ActiveRecord $model */
        $model = new $this->modelClass();
        $params = \Yii::$app->getRequest()->getBodyParams();
        $this->_saveModel($model, $this->_prepareParamsForCreateItem($params));
        return $model;
    }

    /**
     * @param int $id
     * @return db\ActiveRecord
     * @throws base\InvalidConfigException
     * @throws web\ServerErrorHttpException
     */
    public function actionUpdate($id) {
        /** @var db\ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne(['id' => $id]);
        $params = \Yii::$app->getRequest()->getBodyParams();
        $this->_saveModel($model, $this->_prepareParamsForUpdateItem($params));
        return $model;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function _prepareParamsForCreateItem(array $params = []) {
        return $params;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function _prepareParamsForUpdateItem(array $params = []) {
        return $params;
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
     * @throws base\InvalidConfigException
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

    /**
     * @param string $modelClass
     * @return db\ActiveQuery
     * @throws base\InvalidConfigException
     */
    protected function _getActiveQuery($modelClass) {
        /** @var db\ActiveRecord $modelClass */
        $result = $modelClass::find();
        $filterParams = \Yii::$app->getRequest()->getQueryParam(self::FILTER_FIELD);
        if (!is_array($filterParams) || count($filterParams) === 0) {
            return $result;
        }

        $columnNames = $modelClass::getTableSchema()->getColumnNames();
        foreach ($filterParams as $key => $value) {
            if (array_search($key, $columnNames) !== false) {
                $result->andWhere([$key => $value]);
            }
        }
        return $result;
    }

    /**
     * @return bool
     */
    protected function _canUserEditTerms() {
        return \Yii::$app->user->can('editTerms');
    }

    /**
     * @return bool
     */
    protected function _canUserEditComments() {
        return \Yii::$app->user->can('editComments');
    }

    /**
     * @param base\Model $model
     * @return bool
     */
    protected function _isOwnItem(base\Model $model) {
        return \Yii::$app->user->can('updateOwnItems', $model);
    }
}