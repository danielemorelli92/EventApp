<?php

namespace Tests\Feature;

use App\Models\Comment;
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

        self::assertNotNull($comment->author, 'l\'autore del commento non viene visualizzato');
    }
}
