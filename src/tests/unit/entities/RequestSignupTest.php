<?php

namespace modules\client\src\tests\unit\entities;

use Codeception\Test\Unit;
use modules\client\common\models\Client;

class RequestSignupTest extends Unit
{
    public function testSuccess()
    {
        $user = Client::requestSignup(
            $email = 'email@site.com',
            $password = 'password'
        );

        $this->assertEquals($email, $user->email);
        $this->assertNotEmpty($user->password_hash);
        $this->assertNotEquals($password, $user->password_hash);
        $this->assertNotEmpty($user->created_at);
        $this->assertNotEmpty($user->auth_key);
        $this->assertNotEmpty($user->email_confirm_token);
        $this->assertNotEmpty($user->info);
        $this->assertTrue($user->isInactive());
        $this->assertFalse($user->isActive());
    }
}