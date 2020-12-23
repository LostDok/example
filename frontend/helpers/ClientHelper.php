<?php


namespace modules\client\frontend\helpers;


use modules\client\common\models\ClientInfo;
use modules\client\common\models\Organization;
use Yii;

class ClientHelper
{
    public static function getPreviewUrl(ClientInfo $info)
    {
        return $info->getThumbFileUrl('photo', 'preview', Yii::getAlias('@web/images/default-user-image.png'));
    }

    public static function getOrganizationPreviewUrl(Organization $organization)
    {
        return $organization->getThumbFileUrl('photo', 'preview', Yii::getAlias('@web/images/profile-org-photo.png'));
    }
}