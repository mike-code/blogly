<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogEntryTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserAuthentication()
    {
        $user  = factory(\App\Models\User::class)->create();
        $this->assertNotNull($user);

        $response = $this->json('POST', route('login'), ['name' => $user->name, 'password' => 'secret']);

        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]);
    }

    public function testBlogEntryModel()
    {
        $user  = factory(\App\Models\User::class)->create();
        $entry = factory(\App\Models\BlogEntry::class)->create(['user' => $user]);
        $this->assertNotNull($entry);

        $this->assertEquals($user->id, $entry->author_id);
        $this->assertEquals($user->name, $entry->author_name);
    }

    public function testBlogEntryFetch()
    {
        $entry = factory(\App\Models\BlogEntry::class)->create();

        $response = $this->json('GET', route('blog.entry') . "/{$entry->_id}");

        $response->assertStatus(200)
                 ->assertJson([
                    '_id'          => $entry->_id,
                    'title'        => $entry->title,
                    'content'      => $entry->content,
                    'is_published' => false,
                    'author_id'    => $entry->author_id,
                ]);
    }

    public function testBlogEntryDelete()
    {
        $entry = factory(\App\Models\BlogEntry::class)->create();

        $response = $this->json('DELETE', route('blog.entry') . "/{$entry->_id}");
        $response->assertStatus(401);

        $response = $this->json('POST', route('login'), ['name' => $entry->author_name, 'password' => 'secret']);
        $response->assertStatus(200);

        $response = $this->json('DELETE', route('blog.entry') . "/{$entry->_id}");
        $response->assertStatus(204);
    }

    public function testBlogEntryCreate()
    {
        $user  = factory(\App\Models\User::class)->create();

        $response = $this->json('POST', route('blog.entry'), ['title' => 'My Title', 'content' => 'Lipsum']);
        $response->assertStatus(401);

        $response = $this->json('POST', route('login'), ['name' => $user->name, 'password' => 'secret']);
        $response->assertStatus(200);

        $response = $this->json('POST', route('blog.entry'), ['title' => 'My Title', 'content' => 'Lipsum']);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                    '_id',
                    'title',
                    'content',
                    'is_published',
                    'author_id',
                ]);

        $response_data = $response->decodeResponseJson();

        $response = $this->json('GET', route('blog.entry') . "/{$response_data['_id']}");

        $response->assertStatus(200)
                 ->assertJson([
                    '_id'          => $response_data['_id'],
                    'title'        => $response_data['title'],
                    'content'      => $response_data['content'],
                    'is_published' => false,
                    'author_id'    => $response_data['author_id'],
                ]);
    }
}
