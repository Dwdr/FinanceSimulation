<?php

namespace App\View\Components\Inputs;

use App\Traits\StringHelper;
use Illuminate\View\Component;

class DualListBox extends Component {
    use StringHelper;

    /**
     * slot element:
     *  <option value="VALUE">OPTION_NAME</option>
     *
     * blade EXAMPLE:
     *
     * <x-inputs.duallistbox
     *  name="departments[]"
     *  label="Department"
     *  >
     *      @foreach($departments as $d)
     *          <option value="{{ $d->id }}">{{ $d->name }}</option>
     *      @endforeach
     * </x-inputs.duallistbox>
     *
     */

    /**
     * label text value (String)
     * Default: "DualListBox"
     */
    public $label;

    /**
     * input is readonly? (Boolean)
     * Default: false
     */
    public $isReadonly;

    /**
     * TODO
     * input value when show mode
     */
    public $value;

    /**
     * input element id and name. (String)
     * Default: "duallistbox"
     *
     * e.g. $name = "gender[en-gb]"
     * input element id = "id_gender_en-gb"
     * input element name = "gender[en-gb]"
     *
     * e.g. $name = "gender"
     * input element id = "id_gender"
     * input element name = "gender"
     */
    public $name;

    /**
     * (Boolean)
     * set input element is required
     */
    public $required;

    /**
     * (String)
     * set hints small text
     */
    public $hints;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'DualListBox', $isReadonly = false, $value = '', $name = 'duallistbox', $required = false, $hints = '') {
        $this->label = $label;
        $this->isReadonly = $isReadonly;
        $this->value = $value;
        $this->name = $name;
        $this->required = $required;
        $this->hints = $hints;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.inputs.duallistbox');
    }
}
