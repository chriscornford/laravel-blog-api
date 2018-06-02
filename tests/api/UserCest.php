<?php

class UserCest
{
    public function register(ApiTester $I)
    {
        $body = [
            'name' => 'Chris',
            'email' => 'chrisc@test.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/users', $body);
        $I->seeResponseCodeIs(201);
    }

    public function login(ApiTester $I)
    {
        // TODO: Find a better way to get the client secret
        $client = DB::table('oauth_clients')->where('id', 2)->first();
        $clientSecret = $client->secret;

        $user = factory(App\User::class)->create();
        $body = [
            'username' => $user->email,
            'password' => 'secret',
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => $clientSecret
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/oauth/token', $body);
        $I->seeResponseCodeIs(200);
    }

    public function refresh(ApiTester $I)
    {
        // TODO: Find a better way to get the client secret
        $client = DB::table('oauth_clients')->where('id', 2)->first();
        $clientSecret = $client->secret;

        $user = factory(App\User::class)->create();
        $body = [
            'username' => $user->email,
            'password' => 'secret',
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => $clientSecret
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/oauth/token', $body);
        $I->seeResponseCodeIs(200);

        $refreshToken = $I->grabDataFromResponseByJsonPath('$.refresh_token')[0];
        $body = [
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
            'client_id' => 2,
            'client_secret' => $clientSecret
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/oauth/token', $body);
        $I->seeResponseCodeIs(200);
    }
}
