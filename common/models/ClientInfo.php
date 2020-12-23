<?php

namespace modules\client\common\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use common\adminLTE\widgets\fileinput\behaviors\DeletableImageUploadBehavior;
use Yii;

/**
 * This is the model class for table "{{%client_info}}".
 *
 * @property int $client_id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $username
 * @property integer $display_type
 * @property string|null $phone
 * @property string|null $birth_date
 * @property int|null $gender
 * @property int|null $work_line_id
 * @property string|null $photo
 * @property int|null $organization_id
 *
 * @property Organization $organization
 * @property ClientWorkLine $workLine
 *
 * @mixin DeletableImageUploadBehavior
 */
class ClientInfo extends \yii\db\ActiveRecord
{
    const DISPLAY_NAME = 1;
    const DISPLAY_USERNAME = 2;

    public static function getDisplayTypeMap()
    {
        return [
            self::DISPLAY_NAME => 'Отображать имя',
            self::DISPLAY_USERNAME => 'Отображать ник',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client_info}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender', 'work_line_id', 'organization_id'], 'integer'],
            [['birth_date'], 'safe'],
            [['name', 'surname', 'username'], 'string', 'max' => 255],
            [['phone'], 'string'],
            [['phone'], PhoneInputValidator::class],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
            [['work_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientWorkLine::class, 'targetAttribute' => ['work_line_id' => 'id']],
            ['display_type', 'in', 'range' => array_keys(self::getDisplayTypeMap())],
            ['photo', 'image'],

            ['deletePhoto', 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'username' => 'Ник',
            'display_type' => 'Вид',
            'phone' => 'Телефон',
            'birth_date' => 'Дата рождения',
            'gender' => 'Пол',
            'work_line_id' => 'Род деятельности',
            'photo' => 'Фото',
            'organization_id' => 'Organization ID',
        ];
    }

    public $deletePhoto;

    public function behaviors(): array
    {
        return [
            [
                'class' => DeletableImageUploadBehavior::class,
                'attribute' => 'photo',
                'deleteAttribute' => 'deletePhoto',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/clients/[[attribute_client_id]].[[extension]]',
                'fileUrl' => '@static/origin/clients/[[attribute_client_id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/clients/[[profile]]_[[attribute_client_id]].[[extension]]',
                'thumbUrl' => '@static/cache/clients/[[profile]]_[[attribute_client_id]].[[extension]]',
                'thumbs' => [
                    'preview' => ['width' => 250, 'height' => 250],
                ],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkLine()
    {
        return $this->hasOne(ClientWorkLine::class, ['id' => 'work_line_id']);
    }

    public function getFullName()
    {
        return trim($this->name . ' ' . $this->surname);
    }

    public function getDisplayName()
    {
        return $this->display_type === self::DISPLAY_NAME ? $this->getFullName() : $this->username;
    }

    public static function primaryKey()
    {
        return ['client_id'];
    }
}
