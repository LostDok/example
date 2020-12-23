<?php

namespace modules\client\common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_work_line}}".
 *
 * @property int $id
 * @property string $name
 *
 */
class OrganizationWorkLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization_work_line}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }


    /**
    * @var array
    */
    protected static $_map;

    /**
    * @return array
    */
    public static function getMap()
    {
        if (self::$_map)
            return self::$_map;
        return self::$_map = yii\helpers\ArrayHelper::map(
            self::find()->select(['id', 'name'])->asArray()->all(),
            'id',
            'name'
        );
    }
}
