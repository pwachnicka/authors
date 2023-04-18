<?php

use App\Models\Author;
use Tests\TestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;

class AuthorTest extends TestCase
{
    use DatabaseTransactions;

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
    //z czasem zamiast setUp używać dataSeeder

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
     * /api/authors [GET]
     */
    public function testShouldReturn15Authors(): void
    {
        $this->get('api/authors', []);
        // $this->assertJsonCount();
        // $this->assertJsonCount(15, $key = null);
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
     * /api/authors/id [GET]
     */
    public function testShouldNotReturnAuthor(): void
    {
        $this->get("/api/authors/9999", []);
        $this->seeStatusCode(404);
        $this->seeJsonEquals(['error' => 'Author not found!']);
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
