<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UploadedFile extends Component
{
    public $name;
    public $title;
    public $value;


    public function __construct($name,$title,$value = null)
    {

        $this->name = $name;
        $this->title = $title;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.uploaded-file');
    }
}
