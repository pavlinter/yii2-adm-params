<?php

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
            [['name', 'value'], 'required'],
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
}
