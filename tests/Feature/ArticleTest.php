<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\StoreArticleRequest;
use App\Models\User;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    private $attributes;
    public function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'name'     => 'テスト太郎',
            'email'     => 'hoge@example.com',
            'password' => bcrypt('test'),
        ];
    }
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_登録できる()
    {
        User::create($this->attributes);
        $this->assertDatabaseHas('users', $this->attributes);
    }
}
