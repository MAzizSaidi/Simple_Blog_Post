<?php

namespace App\Mail;

use App\Models\Comments;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommentedPost extends Mailable
{
    use Queueable, SerializesModels;

    private Comments $comment;

    /**
     * Create a new message instance.
     */
    public function __construct(Comments $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Comment Notification'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Mail.Posts.CommentedPost',
            with: [
                'commentContent' => $this->comment->content,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
