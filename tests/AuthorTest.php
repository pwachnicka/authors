<?php

use App\Models\Author;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthorTest extends TestCase
{
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
        $dataToPost = [];
        $this->post("/api/authors", $dataToPost, []);
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
        $author = ['name' => 'Zbigniew Json'];
        $this->post("/api/authors", $author, []);
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
        $dataToPost = ['non_exist' => true];
        $this->post("/api/authors", $dataToPost, []);
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
    public function test_should_update_author_with_one_field(): void
    {
        $updatedValue = [
            'latest_article_published' => "Testing PUT method with feature test"
        ];

        $this->put('/api/authors/4', $updatedValue, []);
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
        $this->seeJsonContains($updatedValue);
    }

    /**
     * /api/authors/id [PUT]
     */
    public function test_should_update_author_with_few_fields()
    {
        $updatedValue = [
            'name' => 'Jane Kowalsky',
            'location' => 'Madrit',
            'latest_article_published' => 'How to learn React?'
        ];

        $this->put('/api/authors/5', $updatedValue, []);
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
        $this->seeJsonContains($updatedValue);
    }

    /**
     * /api/authors/id [PUT]
     */
    public function test_should_return_error_when_edited_author_does_not_exist()
    {
        $updatedValue = [
            'name' => 'Jane Kowalsky'
        ];

        $this->put('/api/authors/99999', $updatedValue, []);
        $this->seeStatusCode(404);
    }

    /**
     * /api/authors/id [PUT]
     */
    public function test_should_return_author_when_author_exist_field_not_exits()
    {
        $updatedValue = [
            'name' => 'Jane Kowalsky',
            'serial_number' => '456ABC123'
        ];

        $this->put("/api/authors/1", $updatedValue, []);
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

    /**
     * /api/authors/id [DELETE]
     */
    public function test_should_return_error_when_deleted_author_does_not_exist()
    {
        $this->delete('/api/authors/2222', [], []);
        $this->seeStatusCode(404);
    }
}
