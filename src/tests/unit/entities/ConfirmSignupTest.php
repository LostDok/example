<?php

namespace modules\client\src\tests\unit\entities;

use Codeception\Test\Unit;
use modules\client\common\models\Client;

class ConfirmSignupTest extends Unit
{
    public function testSuccess()
    {
        $user = new Client([
            'status' => Client::STATUS_INACTIVE,
            'email_confirm_token' => 'token',
        ]);

        $user->confirmSignup();

        $this->assertEmpty($user->email_confirm_token);
        $this->assertFalse($user->isInactive());
        $this->assertTrue($user->isActive());
    }

    public function testAlreadyActive()
    {
        $user = new Client([
            'status' => Client::STATUS_ACTIVE,
            'email_confirm_token' => null,
        ]);

        $this->expectExceptionMessage('Клиент уже активирован.');

        $user->confirmSignup();
    }
}