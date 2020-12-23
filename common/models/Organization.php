<?php

namespace modules\client\common\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use common\adminLTE\widgets\fileinput\behaviors\DeletableImageUploadBehavior;
use Yii;

/**
 * This is the model class for table "{{%organization}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property int|null $work_line_id
 * @property int|null $owner_id
 *
 * @property Client[] $clients
 * @property Client $owner
 * @property OrganizationWorkLine $workLine
 *
 * @mixin DeletableImageUploadBehavior
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['work_line_id', 'owner_id'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['phone'], 'string'],
            [['phone'], PhoneInputValidator::class],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['owner_id' => 'id']],
            [['work_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationWorkLine::class, 'targetAttribute' => ['work_line_id' => 'id']],
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
            'id' => 'ID',
            'name' => 'Название',
            'email' => 'Email',
            'phone' => 'Телефон',
            'photo' => 'Фото',
            'work_line_id' => 'Род деятельности',
            'owner_id' => 'Owner ID',
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
                'filePath' => '@staticRoot/origin/organizations/[[pk]].[[extension]]',
                'fileUrl' => '@static/origin/organizations/[[pk]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/organizations/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl' => '@static/cache/organizations/[[profile]]_[[pk]].[[extension]]',
                'thumbs' => [
                    'preview' => ['width' => 250, 'height' => 250],
                ],
            ],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::class, ['id' => 'client_id'])->viaTable(ClientInfo::tableName(), ['organization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Client::class, ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkLine()
    {
        return $this->hasOne(OrganizationWorkLine::class, ['id' => 'work_line_id']);
    }
}
