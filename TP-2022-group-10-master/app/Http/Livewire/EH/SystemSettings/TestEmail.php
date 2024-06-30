<?php

namespace App\Http\Livewire\EH\SystemSettings;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use function Matrix\trace;

class TestEmail extends Component
{

    public function sendEmail(){

        $subject = 'laravel hr test';
        $body = 'this is call lambda for laravel';

        $email_view = \view('emails.test',compact('subject','body'))->render();

        $response = Http::post(config('constants.EMAIL-API'), [
            'token' => '90cb2f4e-3eec-43c7-b7ae-bc45f755514a',
            'source_email' => 'info@clixells.com',
            'recipient_email' => 'jimmy.li@anchorlab.it',
            'subject' => $subject,
            'body' => $email_view,
        ]);

        $this->emit('alert',$response->body());
    }

    public function render()
    {
        return view('livewire.eh.system_settings.test-email');
    }
}
