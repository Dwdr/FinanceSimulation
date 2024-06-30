<?php

namespace App\View\Components\Inputs;

use App\Traits\StringHelper;
use Illuminate\View\Component;

class Radio extends Component {

    use StringHelper;

    /**
     * (array)
     * radio option item
     * [key => value]
     * Default: [''=>'on']
     * e.g. $option = ['MALE'=> 1,'FEMALE'=>2 ]
     */
    public $option;

    /**
     * label text value (String)
     * Default: "Text"
     */
    public $lang;


    public $label;

    /**
     * input is readonly? (Boolean)
     * Default: false
     */
    public $isReadonly;

    /**
     * (array)
     * input value when isReadonly mode shown
     */
    public $value;

    /**
     * input element id and name. (String)
     * Default: "radio"
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
     * (Boolean)
     * set input form group the style is d-none
     */
    public $hidden;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'Radio', $option = ['' => 'on'], $lang = '', $isReadonly = false, $value = '', $name = 'radio', $required = false, $hidden = false) {
        $this->label = $label;
        $this->option = $option;
        $this->lang = $lang;
        $this->isReadonly = $isReadonly;
        $this->value = $value;
        $this->name = $name;
        $this->required = $required;
        $this->hidden = $hidden;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.inputs.radio');
    }
}
