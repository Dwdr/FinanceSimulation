<?php

namespace App\View\Components\Inputs;

use App\Traits\StringHelper;
use Illuminate\View\Component;

class Checkbox extends Component {

    use StringHelper;

    /**
     * (array)
     * checkbox option item
     * [key => value]
     * Default: [''=>'on']
     * e.g. $option = ['MALE'=> 1,'FEMALE'=>2 ]
     */
    public $option;

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
     * (array)
     * input value when isReadonly mode shown
     * e.g. $option = ['1'=> true,'2'=>ture]
     */
    public $value;

    /**
     * input element id and name. (String)
     * Default: "checkbox"
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
     * multi lang text file path. (String)
     * lang key must mach format
     *
     * // trans($lang.'.checkbox_option_'.strtolower($key))
     *
     * example:
     * $lang = "eh/configurations/gender/detail"
     *
     * // key value in lang array. please add checkbox_option_'.$key to lang array.
     * return [
     *   'checkbox_option_male' => 'Male',
     *   'checkbox_option_female' => 'Female',
     * ];
     *
     * $value = ['MALE'=>1, 'FEMALE=>2]
     */
    public $lang;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'Checkbox', $option = ['' => 'on'], $isReadonly = false, $value = '', $name = 'checkbox', $required = false, $lang = '') {
        $this->label = $label;
        $this->option = $option;
        $this->isReadonly = $isReadonly;
        $this->value = $value;
        $this->name = $name;
        $this->required = $required;
        $this->lang = $lang;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.inputs.checkbox');
    }
}
