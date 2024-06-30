<?php

namespace App\View\Components\Inputs;

use App\Traits\StringHelper;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Text extends Component {

    use StringHelper;

    // Text Component Parameter

    /**
     * the text input type
     * Default: "text". (String)
     * support text, email, password, url, tel, number, hidden.
     */
    public $type;

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
     * Default: "text"
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
     * set input element value max and min validation
     * support input type "text" and "number"
     * if value > 8 and < 12, please set max=12, min=8
     */
    public $max;
    public $min;

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
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'text', $label = 'Text', $isReadonly = false, $value = '', $name = 'text', $required = false, $max = '', $min = '', $placeholder = '', $hints = '') {
        switch ($type) {
            case "text":
            case "email":
            case "password":
            case "url":
            case "tel": //TODO pattern
            case "number":
            case "hidden":
                $this->type = $type;
                break;
            default:
                $this->type = "text";
        }
        $this->label = $label;
        $this->isReadonly = $isReadonly;
        $this->value = $value;
        $this->name = $name;
        $this->required = $required;
        $this->max = $max;
        $this->min = $min;
        $this->placeholder = $placeholder;
        $this->hints = $hints;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.inputs.text');
    }
}
