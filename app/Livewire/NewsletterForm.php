<?php

namespace App\Livewire;

use App\Models\Newsletter;
use Livewire\Component;

class NewsletterForm extends Component
{
    public string $email = '';

    public bool $subscribed = false;

    public function subscribe(): void
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        Newsletter::firstOrCreate(
            ['email' => $this->email],
            ['is_active' => true]
        );

        $this->subscribed = true;
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.newsletter-form');
    }
}
