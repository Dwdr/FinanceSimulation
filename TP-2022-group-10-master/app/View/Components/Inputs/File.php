<?php

namespace App\View\Components\Inputs;

use App\Traits\StringHelper;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class File extends Component {

    use StringHelper;

    /**
     * the file input type
     * Default: "single". (String)
     * support single, multiple
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
     * view is edit mode? (Boolean)
     * Default: false
     *
     * if is edit, file can be deleted
     */
    public $isEdit;

    /**
     * input value (2d array)
     * $value = [
     *  [
     *      'file_name' => $file_name,
     *      'file_source_name' => $file_source_name,
     *      'file_path' => $file_path,
     *      'file_size' => $size,
     *      'file_type' => $file_type,
     *      'file_extension' => $extension,
     *  ],
     *  [
     *      'file_name' => $file_name,
     *      'file_source_name' => $file_source_name,
     *      'file_path' => $file_path,
     *      'file_size' => $size,
     *      'file_type' => $file_type,
     *      'file_extension' => $extension,
     *  ]
     * ]
     */
    public $value;

    /**
     * input element id and name. (String)
     * Default: "file"
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
     * (String)
     * delete file controller route name.
     * to handle file deleted logic.
     * e.g., "eh.employee.file_delete"
     */
    public $deleteRoute;

    /**
     * (String|Number)
     * model id for delete file.
     * to handle file deleted route path.
     * e.g., $e->uuid
     */
    public $deleteModelId;

    /**
     * (Boolean)
     * show mode file display style
     * true is use <ul><li> to display,
     * false, is use third party to display
     *
     * Default: false
     */
    public $legacy;

    /**
     * (Boolean)
     * set input element is required
     */
    public $required;

    /**
     * (String)
     * set file input element placeholder
     */
    public $placeholder;

    /**
     * (String)
     * set tips small text
     */
    public $tips;

    /**
     * (Number)
     * set file input max file size (kb)
     *  0 mean no limited
     *
     * Default: 0
     */
    public $fileMax;

    /**
     * (Number)
     * set file input max file amount
     *  0 mean no limited
     *
     * Default: 0
     */
    public $fileMaxCount;

    /**
     * (Number)
     * set file input min file amount
     *  0 mean no limited
     *
     * Default: 0
     */
    public $fileMinCount;

    /**
     * (array)
     * the list of allowed file types for upload.
     * This by default is set to null which means the plugin supports all file types for upload.
     * If an invalid file type is found, then a validation error message as set in msgInvalidFileType will be raised.
     * The following types as set in fileTypeSettings are available for setup.
     *
     * https://plugins.krajee.com/file-input/plugin-options#allowedFileTypes
     */
    public $allowedFileTypes;

    /**
     * (array)
     * the list of allowed file extensions for upload.
     * This by default is set to null which means the plugin supports all file extensions for upload.
     * If an invalid file extension is found, then a validation error message as set in msgInvalidFileExtension will be raised.
     *
     * https://plugins.krajee.com/file-input/plugin-options#allowedFileExtensions
     */
    public $allowedFileExtensions;

    /**
     * (String)
     * The accept attribute value is a string that defines the file types the file input should accept.
     *
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file#accept
     */
    public $accept;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'single', $label = 'Text', $isReadonly = false, $isEdit = false, $legacy = false, $value = '', $name = 'file', $deleteRoute = '', $deleteModelId = '', $required = false, $placeholder = '', $tips = '', $fileMax = 0, $fileMinCount = 0, $fileMaxCount = 0, $allowedFileExtensions = '', $allowedFileTypes = '', $accept = '') {
        switch ($type) {
            case "single":
            case "multiple":
                $this->type = $type;
                break;
            default:
                $this->type = "single";
        }
        $this->label = $label;
        $this->isReadonly = $isReadonly;
        $this->isEdit = $isEdit;
        $this->value = $value;
        $this->name = $name;
        $this->deleteRoute = $deleteRoute;
        $this->deleteModelId = $deleteModelId;
        $this->legacy = $legacy;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->tips = $tips;
        $this->fileMax = $fileMax;
        $this->fileMaxCount = $fileMaxCount;
        $this->fileMinCount = $fileMinCount;
        $this->allowedFileTypes = $allowedFileTypes;
        $this->allowedFileExtensions = $allowedFileExtensions;
        $this->accept = $accept;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.inputs.file');
    }
}
