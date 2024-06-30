<?php

namespace App\View\Components\Inputs;

use App\Traits\StringHelper;
use Illuminate\View\Component;

class Switch2 extends Component {

    use StringHelper;

    /**
     * blade EXAMPLE:
     * <x-inputs.switch2
     *      label="{{ __('eh/configurations/bank/detail.lb_is_active') }}"
     *      :isReadonly="$mode['isModeShow']"
     *      value="{{$b->is_active ?? true}}"
     *      name="is_active"
     *      onText="{{ __('eh/configurations/bank/detail.select_option_yes') }}"
     *      offText="{{ __('eh/configurations/bank/detail.select_option_no') }}"
     * />
     */

    /**
     * label text value (String)
     * Default: "Switch"
     */
    public $label;

    /**
     * input is readonly? (Boolean)
     * Default: false
     */
    public $isReadonly;

    /**
     * input value (Boolean)
     * true | false
     */
    public $value;

    /**
     * input element id and name. (String)
     * Default: "switch"
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
     * set off button text
     *
     * Default: "OFF"
     */
    public $offText;

    /**
     * (String)
     * set on button text
     *
     * Default: "ON"
     */
    public $onText;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'Switch', $isReadonly = false, $value = '', $name = 'switch', $required = false, $offText = 'OFF', $onText = 'ON') {
        $this->label = $label;
        $this->isReadonly = $isReadonly;
        $this->value = $value;
        $this->name = $name;
        $this->required = $required;
        $this->offText = $offText;
        $this->onText = $onText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.inputs.switch2');
    }
}
