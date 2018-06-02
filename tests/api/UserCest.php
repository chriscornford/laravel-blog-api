<?php

class UserCest
{
    public function register(ApiTester $I)
    {
        $body = [
            'name' => 'Chris',
            'email' => 'chris@test.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/register', $body);
        $I->seeResponseCodeIs(201);
    }
}
