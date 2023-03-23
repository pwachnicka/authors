<?php

use App\Models\Author;
use Tests\TestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthorTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /api/authors [GET]
     */
    public function testShouldReturnAllAuthors(): void
    {
        $this->get("/api/authors", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
                'github',
                'twitter',
                'location',
                'latest_article_published',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * /api/authors/id [GET]
     */
    public function testShouldReturnAuthor(): void
    {
        $this->get("/api/authors/2", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'id',
            'name',
            'email',
            'github',
            'twitter',
            'location',
            'latest_article_published',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * /api/authors [POST]
     */
    public function testShouldCreateAuthor(): void
    {
        $this->post("/api/authors", Author::factory()->definition(), []);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'id',
            'name',
            'email',
            'github',
            'twitter',
            'location',
            'latest_article_published',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * /api/authors/id [PUT]
     */
    public function testShouldUpdateAuthor(): void
    {
        $parameters = [
            'latest_article_published' => 'Testing PUT method with feature test'
        ];

        $this->put('/api/authors/4', $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'id',
            'name',
            'email',
            'github',
            'twitter',
            'location',
            'latest_article_published',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * /api/authors/id [DELETE]
     */
    public function testShouldDeleteAuthor(): void
    {
        $this->delete('api/authors/11', [], []);
        $this->seeStatusCode(200);
        $this->seeJsonEquals(['message' => 'Delete succesfully']);
    }
}
