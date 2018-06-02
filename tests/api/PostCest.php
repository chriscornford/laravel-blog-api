<?php

class PostCest
{
    public function create(ApiTester $I)
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

        $accessToken = $I->grabDataFromResponseByJsonPath('$.access_token')[0];

        $body = [
            'title' => 'Test post',
            'content' => 'Test content',
            'slug' => 'test-post-slug'
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $accessToken);
        $I->sendPost('/api/posts', $body);
        $I->seeResponseCodeIs(201);
    }
}
