<?php

namespace App\View\Components\Inputs;

use App\Traits\StringHelper;
use Illuminate\View\Component;

class Select2 extends Component {

    use StringHelper;

    /**
     * slot EXAMPLE:
     *  <option value="VALUE">OPTION_NAME</option>
     *
     * blade EXAMPLE:
     *
     * <x-inputs.select2
     *  :label="__('eh/employee/detail.lb_gender')"
     *  :isReadonly="$mode['isModeShow']"
     *  name="gender_id"
     *  value="{{$e->gender->gender[App::getLocale()]??'-'}}"
     * >
     *      @if(!$mode['isModeShow'])
     *          @foreach($genders as $g)
     *              <option
     *                  value="{{ $g->id }}"
     *                  @if($mode['isModeShow'] || $mode['isModeEdit'] || $mode['isModeClone'])
     *                      @if($g->id===$e->gender_id)
     *                          selected="selected"
     *                      @endif
     *                  @endif
     *              >{{ $g->gender[App::getLocale()] }}</option>
     *          @endforeach
     *      @endif
     * </x-inputs.select2>
     *
     */


    /**
     * label text value (String)
     * Default: "Select2"
     */
    public $label;

    /**
     * (array)
     * input value when isReadonly mode shown
     */
    public $value;

    /**
     * input is readonly? (Boolean)
     * Default: false
     */
    public $isReadonly;

    /**
     * input element id and name. (String)
     * Default: "select2"
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
     * set select element is multiple option
     */
    public $multiple;

    /**
     * (Boolean)
     * set input form group the style is d-none
     */
    public $hidden;

    /**
     * (Boolean)
     * when mode is show, show the slot element
     */
    public $showCustom;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'Select2', $value = '', $isReadonly = false, $name = 'select2', $required = false, $multiple = false, $hidden = false, $showCustom = false) {
        $this->label = $label;
        $this->value = $value;
        $this->isReadonly = $isReadonly;
        $this->name = $name;
        $this->required = $required;
        $this->multiple = $multiple;
        $this->hidden = $hidden;
        $this->showCustom = $showCustom;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.inputs.select2');
    }
}
