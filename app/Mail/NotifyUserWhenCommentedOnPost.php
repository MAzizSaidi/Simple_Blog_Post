<?php

namespace App\Mail;

use App\Models\Comments;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NotifyUserWhenCommentedOnPost extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Comments $comment;

    /**
     * Create a new message instance.
     */
    public function __construct(Comments $comment)
    {
        $this->comment = $comment->load('commentable', 'user', 'user.image');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Comment on the Blog Post You Engaged With!'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $imagePath = $this->comment->user->image->path ?? null;
        $userAvatarUrl = null;

        if ($imagePath) {
            if (Str::startsWith($imagePath, 'images/profile_pics')) {
                $userAvatarUrl = public_path($imagePath);
            } elseif (Str::startsWith($imagePath, '/storage/avatars/')) {
                $userAvatarUrl = public_path($imagePath);
            }
//            dd($userAvatarUrl);
        }

        return new Content(
            view: 'Mail.Posts.NotifyUserWhenCommentedOnPost',
            with: [
                'commentContent' => $this->comment->content,
                'postTitle' => $this->comment->commentable->title,
                'user' => $this->comment->user->name,
                'userAvatar' => $userAvatarUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {

        return [];
    }
}
