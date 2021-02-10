<?php

namespace Tests\Feature;

use App\Models\Author;
use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_libraty()
    {        
        $response = $this->post('/books', $this->data());  

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect('/books/' . $book->id);
    }

    /** @test */
    public function a_title_is_required()
    {        
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Mirko'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {        
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect('/books/' . $book->id);
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete('/books/' . $book->id);

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_is_automatically_added()
    {
        $this->post('/books', [
            'title' => 'Cool Title',
            'author_id' => 'Mirko'
        ]);

        $book = Book::first();
        $author = Author::first();

        // dd($book->author_id);

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());   
    }

    private function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Mirko'
        ];
    }
}
