<?php


namespace modules\client\frontend\helpers;


class ProfileTabs
{
    const TAB_INFO = 'information';
    const TAB_ORGANIZATION = 'organization';
    const TAB_SECURITY = 'security';

    public static function getPositions()
    {
        return [
            self::TAB_INFO => 0,
            self::TAB_ORGANIZATION => 2,
            self::TAB_SECURITY => 3,
        ];
    }
}