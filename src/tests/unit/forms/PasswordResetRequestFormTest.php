<?php

namespace modules\client\src\tests\unit\forms;

use Yii;
use modules\client\src\forms\auth\PasswordResetRequestForm;
use modules\client\common\fixtures\ClientFixture as ClientFixture;
use modules\client\common\models\Client;

class PasswordResetRequestFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => ClientFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    public function testWithWrongEmailAddress()
    {
        $model = new PasswordResetRequestForm();
        $model->email = 'not-existing-email@example.com';
        expect_not($model->validate());
    }

    public function testInactiveClient()
    {
        $user = $this->tester->grabFixture('user', 1);
        $model = new PasswordResetRequestForm();
        $model->email = $user['email'];
        expect_not($model->validate());
    }

    public function testSuccessfully()
    {
        $userFixture = $this->tester->grabFixture('user', 0);
        
        $model = new PasswordResetRequestForm();
        $model->email = $userFixture['email'];
        $user = Client::findOne(['password_reset_token' => $userFixture['password_reset_token']]);

        expect_that($model->validate());
    }
}
