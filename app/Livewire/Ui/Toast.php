<?php

namespace App\Livewire\Ui;

use Livewire\Component;

class Toast extends Component
{
    public $toasts = [];

    protected $listeners = ['toast' => 'addToast'];

    public function addToast($message, $type = 'success')
    {
        $this->toasts[] = [
            'id' => uniqid(),
            'message' => $message,
            'type' => $type,
        ];
    }

    public function removeToast($id)
    {
        $this->toasts = collect($this->toasts)->reject(fn($toast) => $toast['id'] === $id)->values()->toArray();
    }

    public function render()
    {
        return view('livewire.ui.toast');
    }
}
