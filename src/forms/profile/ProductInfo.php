<?php


namespace modules\client\src\forms\profile;


use borales\extensions\phoneInput\PhoneInputValidator;
use modules\client\common\models\Client;
use modules\client\common\models\ClientWorkLine;
use yii\base\Model;

class ProductInfo extends Model
{
    public $name;
    public $surname;
    public $workLineId;
    public $phone;
    public $cardName;
    public $cardNumber;
    public $cvc;

    public function __construct(Client $client, $config = [])
    {
        parent::__construct($config);
        $this->name = $client->info->name;
        $this->surname = $client->info->surname;
        $this->workLineId = $client->info->work_line_id;
        $this->phone = $client->info->phone;
        $this->cardName = $client->card->name;
        $this->cardNumber = $client->card->number;
        $this->cvc = $client->card->cvc;
    }

    public function rules()
    {
        return [
            [['name', 'workLineId', 'phone', 'cardName', 'cardNumber', 'cvc'], 'required'],
            [['name', 'surname'], 'string', 'max' => 255],
            [['phone'], 'string'],
            [['phone'], PhoneInputValidator::class],
            [['workLineId'], 'exist', 'skipOnError' => true, 'targetClass' => ClientWorkLine::class, 'targetAttribute' => ['workLineId' => 'id']],
            [['cardName', 'cardNumber'], 'string'],
            [['cvc'], 'string', 'min' => 3, 'max' => 3],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'surname' => 'Ваша фамилия',
            'workLineId' => 'Род деятельности',
            'phone' => 'Телефон',
            'cardName' => 'Имя на карте',
            'cardNumber' => 'Номер карты',
            'cvc' => 'CVC',
        ];
    }
}