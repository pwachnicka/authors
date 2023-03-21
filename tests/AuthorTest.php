<?php

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
        $parameters = [
            'name' => 'TesingTesters',
            'email' => 'test@test.com',
            'github' => 'tttt',
            'twitter' => 'tttt',
            'location' => 'Spain',
            'latest_article_published' => 'Testing Lumen API With PHPUnit Tests'
        ];

        $this->post("/api/authors", $parameters, []);
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
}
