<?php

namespace App\Http\Livewire;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Counter extends Component
{
    public Model $fichehor;
    public string $field;

    public bool $state;

    public function mount()
    {
        $this->state = (bool) $this->fichehor->getAttribute($this->field);
    }
    public function render()
    {
        return view('livewire.counter');
    }

    public function updating($field, $value)
    {
        $this->fichehor->setAttribute($this->field, $value)->save();
    }
}
