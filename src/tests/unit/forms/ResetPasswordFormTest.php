<?php

namespace modules\client\src\tests\unit\forms;

use modules\client\src\forms\auth\ResetPasswordForm;

class ResetPasswordFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function testCorrectToken()
    {
        $form = new ResetPasswordForm();
        $form->password = 'new-password';
        expect_that($form->validate());
    }
}
