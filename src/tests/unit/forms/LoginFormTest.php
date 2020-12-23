<?php

namespace modules\client\src\tests\unit\forms;

use Yii;
use modules\client\src\forms\auth\LoginForm;
use modules\client\common\fixtures\ClientFixture;

/**
 * Login form test
 */
class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \modules\client\src\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'client' => [
                'class' => ClientFixture::className(),
                'dataFile' => codecept_data_dir() . 'client.php'
            ]
        ]);
    }

    public function testBlank()
    {
        $model = new LoginForm([
            'username' => '',
            'password' => '',
        ]);

        expect_not($model->validate());
    }

    public function testCorrect()
    {
        $model = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]);

        expect_that($model->validate());
    }
}
