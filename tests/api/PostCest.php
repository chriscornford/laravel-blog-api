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

    public function show(ApiTester $I)
    {
        $post = factory(App\Post::class)->create();

        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('/api/posts/' . $post->id);
        $I->seeResponseCodeIs(200);
    }

    public function index(ApiTester $I)
    {
        factory(App\Post::class)->create();
        factory(App\Post::class)->create();

        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('/api/posts');
        $I->seeResponseCodeIs(200);
    }

    public function delete(ApiTester $I)
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

        $post = factory(App\Post::class)->create(['author_id' => $user->id]);

        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $accessToken);
        $I->sendDELETE('/api/posts/' . $post->id);
        $I->seeResponseCodeIs(204);
    }

    public function update(ApiTester $I)
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

        $post = factory(App\Post::class)->create(['author_id' => $user->id]);

        $body = [
            'title' => 'interesting post'
        ];

        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $accessToken);
        $I->sendPUT('/api/posts/' . $post->id, $body);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContains('interesting post');
    }
}
