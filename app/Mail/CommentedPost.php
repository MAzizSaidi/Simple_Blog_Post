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
        // Resolve the user avatar path
        $imagePath = $this->comment->user->image->path ?? null;
        $userAvatarUrl = null;

        if ($imagePath) {
            // Generate the public URL for the image using asset()
            if (str_starts_with($imagePath, 'images/profile_pics')) {
                $userAvatarUrl = $imagePath ; // Correctly generate URL for public images
//                dd($userAvatarUrl);
            } elseif (str_starts_with($imagePath, 'storage/avatars/')) {
                $userAvatarUrl = Storage::url($imagePath);  // Correctly generate URL for storage files
            }
        }

        return new Content(
            view: 'Mail.Posts.CommentedPost',
            with: [
                'commentContent' => $this->comment->content,
                'postTitle' => $this->comment->commentable->title,
                'user' => $this->comment->user->name,
                'userAvatar' => $userAvatarUrl,  // URL used in email template
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
        $attachmentPath = null;

        if ($imagePath) {
            // Resolve the correct file path for the attachment
            if (str_starts_with($imagePath, 'images/profile_pics')) {
                $attachmentPath = public_path($imagePath);  // File path for public images
            } elseif (str_starts_with($imagePath, 'storage/avatars/')) {
                $attachmentPath = storage_path('app/public/avatars/' . basename($imagePath));  // File path for storage images
            }

            // Check if the file exists before attaching
            if ($attachmentPath && file_exists($attachmentPath)) {
                return [
                    Attachment::fromPath($attachmentPath)
                        ->as('user-avatar.jpg')
                        ->withMime('image/jpeg'),
                ];
            }
        }

        return [];
    }
}
