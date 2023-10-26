<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CommentWritten
{
    use Dispatchable, SerializesModels;

    public $comment;

    public $user;
    public $commentCount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, $commentCount)
    {
        $this->comment = $comment;
        $this->commentCount = $commentCount;
    }
}
