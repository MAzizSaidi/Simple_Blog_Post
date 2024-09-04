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

class CommentedPost extends Mailable
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
        // Resolve the full path of the user avatar
        $imagePath = $this->comment->user->image->path ?? null;

        if ($imagePath) {
            // Normalize the image path (remove leading slashes if any)
            $normalizedPath = ltrim($imagePath, '/');
//            dd($normalizedPath);
            // Determine the correct path based on the format
            if (str_starts_with($normalizedPath, 'images/profile_pics')) {
                // Path for dummy data or specific format
                $userAvatarPath = public_path($normalizedPath);
            } elseif (str_starts_with($normalizedPath, 'storage/avatars/')) {
                // Path for actual user uploads
                $userAvatarPath = public_path($normalizedPath);
            } else {
                // Handle unknown path formats
                $userAvatarPath = null;
            }
        } else {
            $userAvatarPath = null; // No image path found
        }

        // Debugging: Check what the resolved path is
//        dd($userAvatarPath);

        // ... rest of your content logic

        return new Content(
            view: 'Mail.Posts.CommentedPost',
            with: [
                'commentContent' => $this->comment->content,
                'postTitle' => $this->comment->commentable->title,
                'user' => $this->comment->user->name,
                'userAvatar' => $userAvatarPath,
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
        $imagePath = $this->comment->user->image->path ?? null;

        // Determine the correct attachment path
        if ($imagePath && str_starts_with($imagePath, 'images/profile_pics')) {
            $attachmentPath = public_path($imagePath);
        } elseif ($imagePath && str_starts_with($imagePath, 'storage/avatars/')) {
            $attachmentPath = public_path($imagePath);
        } else {
            $attachmentPath = null;
        }

        return $attachmentPath ? [
            Attachment::fromPath($attachmentPath)
                ->as('user-avatar.jpg')
                ->withMime('image/jpeg'),
        ] : [];
    }
}
