<?php


namespace modules\client\common\enums;


use yii2mod\enum\helpers\BaseEnum;

class Gender extends BaseEnum
{
    const MALE = 1;
    const FEMALE = 2;

    /**
     * @var array
     */
    public static $list = [
        self::MALE => 'Мужской',
        self::FEMALE => 'Женский',
    ];
}