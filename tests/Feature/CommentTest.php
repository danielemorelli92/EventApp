<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_comments_can_be_extracted()
    {
        $user = User::factory()->hasComments(3)->create();

        self::assertCount(3, $user->comments, 'alcuni commenti non vengono estratti');
    }

    public function test_the_author_of_a_comment_can_be_extracted()
    {
        $comment = Comment::factory()->forAuthor()->create();

        self::assertNotNull($comment->author, 'l\'autore del commento non viene estratto');
    }

    public function test_the_event_of_a_comment_can_be_estracted()
    {
        $comment = Comment::factory()->forEvent()->create();

        self::assertNotNull($comment->event, 'l\'evento a cui appartiene il commento non viene estratto');
    }

    public function test_all_comments_of_an_event_can_be_estracted()
    {
        $event = Event::factory()->hasComments(3)->create();

        self::assertCount(3, $event->comments, 'non vengono estratti tutti i commenti');
    }

    public function test_a_event_comment_must_be_rendered_on_the_event_page()
    {
        $event = Event::factory()->hasComments(4)->create();
        $comments = $event->comments;

        $response = $this->get('/event/' . $event->id);

        foreach ($comments as $comment) {
            $response->assertSee($comment->content);
        }
    }
}
