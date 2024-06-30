<?php

namespace App\View\Components\Inputs;

use App\Traits\StringHelper;
use Illuminate\View\Component;

class Date extends Component {

    use StringHelper;

    /**
     * the date input type
     * Default: "date". (String)
     * support date <YYYY-MM-DD>,
     *         datetime <YYYY-MM-DD HH:mm>,
     *         year <YYYY>,
     *         time <HH:mm>,
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
     * input value (String)
     * need match type format
     */
    public $value;

    /**
     * input element id and name. (String)
     * Default: "text"
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
     * (Boolean)
     * set input form group the style is d-none
     */
    public $hidden;

    /**
     * (String)
     * set datetimepicker format,
     * if not set, default follow the type format
     */
    public $format;

    /**
     * (String)
     * set input element placeholder
     */
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'date', $label = 'Date', $isReadonly = false, $value = '', $name = 'date', $required = false,$hints='',$hidden = false,$format = '',$placeholder = '') {
        $this->type = $type;
        $this->label = $label;
        $this->isReadonly = $isReadonly;
        $this->value = $value;
        $this->name = $name;
        $this->required = $required;
        $this->hints = $hints;
        $this->hidden = $hidden;
        $this->format = $format;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.inputs.date');
    }
}
