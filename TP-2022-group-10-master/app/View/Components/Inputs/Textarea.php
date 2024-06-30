<?php

namespace App\View\Components\Inputs;

use App\Traits\StringHelper;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Textarea extends Component {

    use StringHelper;

    /**
     * label text value (String)
     * Default: "Text"
     */
    public $label;

    /**
     * input is readonly? (Boolean)
     * Default: false
     */
    public $isReadonly;

    /**
     * input value (String|number)
     */
    public $value;

    /**
     * input element id and name. (String)
     * Default: "textarea"
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
     * (Number)
     * set textarea element maxlength
     */
    public $max;

    /**
     * (Number)
     * set textarea element default box row height
     */
    public $row;

    /**
     * (String)
     * set input element placeholder
     */
    public $placeholder;

    /**
     * (String)
     * set hints small text
     */
    public $hints;

    /**
     * (Boolean)
     * use summernote package
     * https://summernote.org/
     */
    public $isSummernote;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'Textarea', $isReadonly = false, $value = '', $name = 'textarea', $required = false, $max = '', $row = '3', $placeholder='', $hints='',$isSummernote = false) {
        $this->label = $label;
        $this->isReadonly = $isReadonly;
        $this->value = $value;
        $this->name = $name;
        $this->required = $required;
        $this->max = $max;
        $this->row = $row;
        $this->placeholder = $placeholder;
        $this->hints = $hints;
        $this->isSummernote = $isSummernote;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.inputs.textarea');
    }
}
