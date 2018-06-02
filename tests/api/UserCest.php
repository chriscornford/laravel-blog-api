<?php

class UserCest
{
    public function register(ApiTester $I)
    {
        $body = [
            'name' => 'Chris',
            'email' => 'chris@test.com',
            'password' => 'secret',
            'confirm_password' => 'secret'
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/register', $body);
        $I->seeResponseCodeIs(201);
    }
}
