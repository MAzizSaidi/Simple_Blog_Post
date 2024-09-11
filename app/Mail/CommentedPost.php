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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommentedPost extends Mailable implements ShouldQueue
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
            subject: 'New Comment Notification'
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
        } else {
            Log::error('User image path is empty or null.', ['user_id' => $this->comment->user->id]);
        }

        return new Content(
            view: 'Mail.Posts.CommentedPost',
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
        $imagePath = $this->comment->user->image->path ?? null;
        $attachmentPath = null;

        if ($imagePath) {
            if (Str::startsWith($imagePath, 'images/profile_pics')) {
                $attachmentPath = public_path($imagePath);
            } elseif (Str::startsWith($imagePath, 'storage/avatars/')) {
                $attachmentPath = storage_path('app/public/avatars/' . basename($imagePath));
            }

            if ($attachmentPath && file_exists($attachmentPath)) {
                return [
                    Attachment::fromPath($attachmentPath)
                        ->as('user-avatar.jpg')
                        ->withMime('image/jpeg'),
                ];
            }
        } else {
            Log::error('User image path is empty or null.', ['user_id' => $this->comment->user->id]);
        }

        return [];
    }
}
