<?php

namespace App\View\Components\Inputs;

use App\Traits\StringHelper;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Timestamp extends Component {

    /**
     * (String)
     * updated_at value
     */
    public $updatedAt;

    /**
     * (String)
     * created_at value
     */
    public $createdAt;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($updatedAt = '',$createdAt='') {
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.inputs.timestamp');
    }
}
