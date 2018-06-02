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
        $I->sendPost('/api/users', $body);
        $I->seeResponseCodeIs(201);
    }

    public function login(ApiTester $I)
    {
        $user = factory(App\User::class)->create();
        $body = [
            'username' => $user->email,
            'password' => 'secret',
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'tUSt1FlDMB1GZfaCffuVnufCsMdtvdpRY5cinu8p'
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/oauth/token', $body);
        $I->seeResponseCodeIs(200);
    }

    public function refresh(ApiTester $I)
    {
        $user = factory(App\User::class)->create();
        $body = [
            'username' => $user->email,
            'password' => 'secret',
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'tUSt1FlDMB1GZfaCffuVnufCsMdtvdpRY5cinu8p'
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/oauth/token', $body);
        $I->seeResponseCodeIs(200);

        $refreshToken = $I->grabDataFromResponseByJsonPath('$.refresh_token')[0];
        $body = [
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
            'client_id' => 2,
            'client_secret' => 'tUSt1FlDMB1GZfaCffuVnufCsMdtvdpRY5cinu8p'
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/oauth/token', $body);
        $I->seeResponseCodeIs(200);
    }
}
