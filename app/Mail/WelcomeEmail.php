<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\User;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
    ){} //$userはメール本文として使用されるbladeファイル内で使用可

    /**
     * Get the message envelope.
     */

    //メール送信者の設定
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('hello@example.com', 'Laravel'), //送信者のメールアドレスと名前
            subject: 'Welcome Email', //件名
        );
    }

    /**
     * Get the message content definition.
     */

    //メール本文の設定
    public function content(): Content
    {
        return new Content(
            view: 'mails.WelcomeEmail', //本文のbladeファイルを指定
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
