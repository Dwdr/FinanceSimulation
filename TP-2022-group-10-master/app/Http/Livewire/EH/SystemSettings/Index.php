<?php

namespace App\Http\Livewire\EH\SystemSettings;

use Livewire\Component;

class Index extends Component
{

    protected $listeners = ['alert' => 'alertHandle'];

    public function alertHandle($message)
    {
        session()->flash('message', $message);
    }

    public function render()
    {
        return view('livewire.eh.system_settings.index');
    }
}
