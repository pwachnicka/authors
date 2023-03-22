<?php

use App\Models\Author;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /**
     * /api/authors [GET]
     */
    public function testShouldReturnAllAuthors()
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
    public function testShouldReturnAuthor()
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
    public function testShouldCreateAuthor()
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
    public function testShouldUpdateAuthor()
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
    public function testShouldDeleteAuthor()
    {
        $this->delete('api/authors/11', [], []);
        $this->seeStatusCode(200);
        $this->seeJsonEquals(['message' => 'Delete succesfully']);
    }
}
