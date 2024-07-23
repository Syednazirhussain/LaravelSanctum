<?php

namespace App\Mail;

use App\Models\Role;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewUserRegisterationEmail extends Mailable
{
    use Queueable, SerializesModels;

    
    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public Role $role,
        public $password
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $admin = User::whereHas('roles', function($query) {
            $query->where('code', 'admin');
        })->first();

        $name = config('mail.from.name');
        $email = config('mail.from.address');
        
        if ($admin !== null) {
            
            $name   = $admin->name;
            $email  = $admin->email;
        }

        return new Envelope(
            from: new Address($email, $name),
            subject: 'New User Registered',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.new-user',
            with: [
                'user'      => $this->user,
                'role'      => $this->role,
                'password'  => $this->password,
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
