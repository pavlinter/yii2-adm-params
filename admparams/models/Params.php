<?php

/**
 * @package yii2-adm-params
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.1
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
					\yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
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
        $key = self::className() . '-params';
        $params = Yii::$app->cache->get($key);
        if ($params === false) {
            $params = \yii\helpers\ArrayHelper::map(self::find()->asArray()->all(), 'name', 'value');
            $query = new \yii\db\Query();
            $sql = $query->select('COUNT(*),MAX(updated_at)')
                ->from(self::tableName())
                ->createCommand()
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
        $model->value = $value;
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
}
