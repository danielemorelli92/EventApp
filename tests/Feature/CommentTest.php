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

    public function test_a_registered_user_can_create_a_comment_on_a_event()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)->post('/comment/' . $event->id, [
            'content' => 'A new comment!'
        ]);

        self::assertNotNull($user->comments->first(), 'il comment non è stato creato');
    }

    public function test_a_registered_user_can_reply_to_a_comment()
    {
        $event = Event::factory()->hasComments(1)->create();
        $comment = $event->comments->first();
        $user = User::factory()->create();

        $this->actingAs($user)->post('/comment/' . $event->id . '/' . $comment->id, [
            'content' => 'A new comment!'
        ]);

        self::assertNotNull($user->comments->first(), 'il comment non è stato creato');
        self::assertEquals($comment->id, $user->comments->first()->parent_id, 'il commento salvato non è una risposta al commento preesistente');
    }

}
