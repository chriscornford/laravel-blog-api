<?php

use App\User;

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

    public function login(ApiTester $I)
    {
        User::create([
            'name' => 'Chris',
            'email' => 'chris@test.com',
            'password' => Hash::make('secret'),
        ]);

        $body = [
            'username' => 'chris@test.com',
            'password' => 'secret',
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'tUSt1FlDMB1GZfaCffuVnufCsMdtvdpRY5cinu8p'
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/oauth/token', $body);
        $I->seeResponseCodeIs(200);
    }

}
