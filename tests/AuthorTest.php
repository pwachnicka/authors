<?php

use App\Models\Author;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    // use DatabaseTransactions;
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Author::factory()->createRandomAuthor(1);
        Author::factory()->createRandomAuthor(2);
        Author::factory()->createRandomAuthor(3);
        Author::factory()->createRandomAuthor(4);
        Author::factory()->createRandomAuthor(5);
        Author::factory()->createRandomAuthor(6);
        Author::factory()->createRandomAuthor(7);
        Author::factory()->createRandomAuthor(8);
        Author::factory()->createRandomAuthor(9);
        Author::factory()->createRandomAuthor(10);
        Author::factory()->createRandomAuthor(11);
        Author::factory()->createRandomAuthor(12);
        Author::factory()->createRandomAuthor(13);
        Author::factory()->createRandomAuthor(14);
        Author::factory()->createRandomAuthor(15);
    }

    /**
     * /api/authors [GET]
     */
    public function test_should_return_all_authors(): void
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
     * /api/authors [GET]
     */
    public function test_should_return_15_authors(): void
    {
        $this->get('api/authors', []);
        $this->response->assertJsonCount(15);
        $this->seeStatusCode(200);
    }

    /**
     * /api/authors/id [GET]
     */
    public function test_should_return_author(): void
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
     * /api/authors/id [GET]
     */
    public function test_should_not_return_author(): void
    {
        $this->get("/api/authors/9999", []);
        $this->seeStatusCode(404);
        $this->seeJsonEquals(['error' => 'Author not found!']);
    }

    /**
     * /api/authors [POST]
     */
    public function test_should_create_author(): void
    {
        $author = Author::factory()->definition();
        $this->post("/api/authors", $author, []);
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
        $this->seeJsonContains([
            'name' => $author['name'],
            'email' => $author['email'],
            'github' => $author['github'],
            'twitter' => $author['twitter'],
            'location' => $author['location'],
            'latest_article_published' => $author['latest_article_published'],

        ]);
    }

    /**
     * /api/authors [POST]
     */
    public function test_should_return_validation_error_when_request_is_empty()
    {
        $this->post("/api/authors", [], []);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'name',
            'email',
            'github',
            'twitter',
            'location',
            'latest_article_published',
        ]);
        $this->seeJsonContains([
            'name' => ["The name field is required."]
        ]);
    }

    /**
     * /api/authors [POST]
     */
    public function test_should_return_validation_error_when_request_has_only_1_field()
    {
        $this->post("/api/authors", ['name' => 'Zbigniew Json'], []);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'email',
            'github',
            'twitter',
            'location',
            'latest_article_published',
        ]);
        $this->seeJsonContains([
            'email' => ["The email field is required."]
        ]);
    }

    /**
     * /api/authors [POST]
     */
    public function test_should_return_validation_error_when_field_does_not_exist()
    {
        $this->post("/api/authors", ['non_exist' => true], []);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'name',
            'email',
            'github',
            'twitter',
            'location',
            'latest_article_published',
        ]);
        $this->seeJsonContains([
            'name' => ["The name field is required."]
        ]);
    }

    /**
     * /api/authors [POST]
     */
    public function test_should_return_error_when_author_exist()
    {
        $author = Author::factory()->definition();
        $this->post("/api/authors", $author, []);
        $this->post("/api/authors", $author, []);

        $this->seeStatusCode(422);
        $this->seeJsonContains([
            'email' => ["The email has already been taken."]
        ]);
    }

    /**
     * /api/authors/id [PUT]
     */
    public function test_should_update_author(): void
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
    public function test_should_delete_author(): void
    {
        $this->delete('api/authors/11', [], []);
        $this->seeStatusCode(200);
        $this->seeJsonEquals(['message' => 'Delete succesfully']);
    }
}
