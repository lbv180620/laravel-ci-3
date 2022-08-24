<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('articles.index'));

        // $response->assertStatus(200)
        $response->assertStatus(400)
            ->assertViewIs('articles.index');
    }

    // 未ログイン状態であれば、ログイン画面にリダイレクトされるはず
    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));

        $response->assertRedirect(route('login'));
    }


    // ログイン済み状態であれば、記事投稿画面が表示されるはず
    public function testAuthCreate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('articles.create'));

        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }
}