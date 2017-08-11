<?php

/**
 * @package yii2-adm-params
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.1.3
 */

namespace pavlinter\admparams\models;

use Yii;

/**
 * This is the model class for table "{{%adm_params}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $updated_at
 */
class Params extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			[
				'class' => \yii\behaviors\TimestampBehavior::className(),
				'updatedAtAttribute' => 'updated_at',
				'attributes' => [
					\yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['updated_at']
				], 
				'value' => new \yii\db\Expression('NOW()')
			],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%adm_params}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique', 'targetAttribute' => 'name'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modelAdm/adm_params', 'ID'),
            'name' => Yii::t('modelAdm/adm_params', 'Name'),
            'value' => Yii::t('modelAdm/adm_params', 'Value'),
            'updated_at' => Yii::t('modelAdm/adm_params', 'Updated At'),
        ];
    }

    /**
     * @return array
     */
    public static function bootstrap()
    {
        static::addDefaultParams();
        $key = static::className() . '-params';
        $params = Yii::$app->cache->get($key);
        if ($params === false) {
            $params = \yii\helpers\ArrayHelper::map(static::find()->asArray()->all(), 'name', 'value');
            $query = new \yii\db\Query();
            $sql = $query->select('COUNT(*),MAX(updated_at)')
                ->from(static::tableName())
                ->createCommand(static::getDb())
                ->getRawSql();

            foreach ($params as $name => $value) {
                if (($value = static::isSerialize($value)) !== false) {
                    $params[$name] = $value;
                }
            }
            Yii::$app->cache->set($key, $params, 86400, new \yii\caching\DbDependency([
                'sql' => $sql,
            ]));
        }
        return $params;
    }

    /**
     * @throws \yii\base\ExitException
     * @throws \yii\db\Exception
     */
    public static function addDefaultParams() {
        if (Yii::$app->request->post('admparams-load-params')) {
            if (Yii::$app->user->can('AdmRoot')) {
                $params = \yii\helpers\ArrayHelper::map(self::find()->asArray()->all(), 'name', 'value');
                $data = [];
                foreach (Yii::$app->params as $name => $value) {
                    if (!isset($params[$name]) && strpos($name, '_') !== 0) {
                        if (in_array(gettype($value), ['integer', 'double', 'string'])) {
                            $data[] = [
                                $name,
                                $value,
                                new \yii\db\Expression('NOW()')
                            ];
                        }
                    }
                }
                if ($data) {
                    Yii::$app->db->createCommand()->batchInsert(static::tableName(), ['name', 'value', 'updated_at'], $data)->execute();
                }
                Yii::$app->end(0, \pavlinter\adm\Adm::goBack(['']));
            }
        }
    }
    /**
     * @return bool
     */
    public function isSerialized()
    {
        return static::isSerialize($this->value) !== false;
    }

    /**
     * @param $value
     * @return bool
     */
    public static function isSerialize($value)
    {
        $data = @unserialize($value);
        if ($value === 'b:0;' || $data !== false) {
            return $data;
        } else {
            return false;
        }
    }

    /**
     * @param $name
     * @param $value
     * @return bool
     */
    public static function change($name, $value)
    {
        $model = static::findOne(['name' => $name]);
        if (!$model) {
            $model = new static;
            $model->name = $name;
        }
        if (is_array($value) || is_object($value)) {
            $value = serialize($value);
        }
        $model->value = (string)$value;
        return $model->save();
    }

    /**
     * @param $name
     * @return int
     */
    public static function remove($name)
    {
        return static::deleteAll(['name' => $name]);
    }

    /**
     * if (Params::hasParams('users.user-1.name')) {
     *
     * }
     * if (Params::hasParams('users.user-1', 'array')) {
     *
     * }
     *
     * @param $key
     * @param null|\Closure $type
     * @param null $data
     * @return bool
     */
    public static function hasParams($key, $type = null, $data = null)
    {
        if ($data === null) {
            $data = Yii::$app->params;
        }
        $params = static::getParams($data, $key, null, true);
        if ($type === null) {
            return $params !== null;
        }

        if ($type instanceof \Closure) {
            return call_user_func($type, $params, $data, $key);
        }
        return gettype($params) !== $type;

    }

    /**
     * @param $data
     * @param $key
     * @param null $default
     * @param bool $strictArr
     * @return null
     */
    public static function getParams($data, $key, $default = null, $strictArr = false)
    {
        if(!is_array($data)){
            return $default;
        }
        $keys = explode('.', $key);

        foreach ($keys as $v) {
            array_shift($keys);
            if(isset($data[$v])){
                if(is_array($data[$v])){
                    if(sizeof($keys)){
                        return static::getNested($data[$v], $keys, $default, $strictArr);
                    }
                    if($strictArr){
                        return $data[$v];
                    }
                    return $default;
                } else {
                    return $data[$v];
                }
            }
        }
        return $default;
    }
    /**
     * @param $data
     * @param $name
     * @param null $default
     * @param bool $strictArr
     * @return null
     */
    public static function getNested($data, $name, $default = null, $strictArr = false)
    {
        if(!is_array($data)){
            return $default;
        }
        if(is_array($name)){
            $keys = $name;
        } else {
            $keys = explode('.', $name);
        }
        foreach ($keys as $key) {
            array_shift($keys);
            if(isset($data[$key])){
                if(is_array($data[$key])){
                    if(sizeof($keys)){
                        return static::getNested($data[$key], $keys, $default, $strictArr);
                    }
                    if($strictArr){
                        return $data[$key];
                    }
                    return $default;
                } else {
                    return $data[$key];
                }
            }
        }
        return $default;
    }


}
