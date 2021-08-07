<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ApplicationTest extends DuskTestCase
{
    use WithoutMiddleware;
    protected static $migrationRun = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$migrationRun) {
            $this->artisan('migrate:fresh');
            $this->artisan('db:seed');
            static::$migrationRun = true;
        }
    }

    /**
     * Index page test
     * @return void
     * @throws \Throwable
     */
    public function testIndexPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('ALI ZAHEDI TEST');
        });
    }

    public function indexBookData()
    {
        return [
            ['GET', 200],
            ['PUT', 405]
        ];
    }

    /**
     * Index book test
     * @dataProvider indexBookData
     * @return void
     */
    public function testIndexBook($method, $status)
    {
        $response = $this->json($method, url('/books'));
        $response->assertStatus($status);
    }

    public function createBookData()
    {
        return [
            ['POST', 200, 'book title', 'book author', ''],
            ['POST', 422, '', '', 'The given data was invalid.'],
            ['POST', 422, '', 'book author', 'The title field is required.'],
            ['POST', 422, 'book title', '', 'The author field is required.'],
            ['PUT', 405, 'book title', 'book author', '']
        ];
    }

    /**
     * Create book test
     * @dataProvider createBookData
     * @return void
     */
    public function testCreateBook($method, $status, $bookTitle, $bookAuthor, $see)
    {
        $response = $this->json($method, url('/books'),
            ['title' => $bookTitle, 'author' => $bookAuthor]);
        $response->assertStatus($status)->assertSee($see);
    }

    public function updateBookData()
    {
        return [
            ['PATCH', 200, 'book title', 'book author', 1, ''],
            ['PATCH', 422, '', '', 1, 'The given data was invalid.'],
            ['PATCH', 422, '', 'book author', 1, 'The title field is required.'],
            ['PATCH', 422, 'book title', '', 1, 'The author field is required.'],
            ['POST', 405, 'book title', 'book author', 1, '']
        ];
    }

    /**
     * Update book test
     * @dataProvider updateBookData
     * @return void
     */
    public function testUpdateBook($method, $status, $bookTitle, $bookAuthor, $id, $see)
    {
        $response = $this->json($method, url('/books/' . $id),
            ['title' => $bookTitle, 'author' => $bookAuthor]);
        $response->assertStatus($status)->assertSee($see);
    }

    public function deleteBookData()
    {
        return [
            ['DELETE', 200, 1, ''],
            ['DELETE', 422, 1000, 'The given data was invalid.'],
            ['POST', 405, 1, '']
        ];
    }

    /**
     * Delete book test
     * @dataProvider deleteBookData
     * @return void
     */
    public function testDeleteBook($method, $status, $id, $see)
    {
        $response = $this->json($method, url('/books/' . $id));
        $response->assertStatus($status)->assertSee($see);
    }

    public function exportCSVData()
    {
        return [
            ['GET', 200, 'title', '', 'text/csv; charset=UTF-8'],
            ['GET', 422, '', 'The columns field is required.', 'application/json'],
            ['POST', 405, 'title', '', 'application/json']
        ];
    }

    /**
     * Export CSV file
     * @dataProvider exportCSVData
     * @return void
     */
    public function testExportCSV($method, $status, $columns, $see, $contentType)
    {
        $response = $this->json($method, url('/books/csv-export'), ['columns' => $columns]);
        $response->assertStatus($status)->assertSee($see)->assertHeader('content-type', $contentType);
    }

    public function exportXMLData()
    {
        return [
            ['GET', 200, 'title', '', 'text/xml; charset=UTF-8'],
            ['GET', 422, '', 'The columns field is required.', 'application/json'],
            ['POST', 405, 'title', '', 'application/json']
        ];
    }

    /**
     * Export XML file
     * @dataProvider exportXMLData
     * @return void
     */
    public function testExportXML($method, $status, $columns, $see, $contentType)
    {
        $response = $this->json($method, url('/books/xml-export'), ['columns' => $columns]);
        $response->assertStatus($status)->assertSee($see)->assertHeader('content-type', $contentType);
    }
}
