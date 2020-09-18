<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UploadedFile extends Component
{
    public $name;
    public $title;


    public function __construct($name,$title)
    {

        $this->name = $name;
        $this->title = $title;
    }

    public function render()
    {
        return view('components.uploaded-file');
    }
}
