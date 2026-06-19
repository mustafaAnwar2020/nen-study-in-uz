<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FileUpload extends Component
{
    public string $accept;

    public function __construct(string $accept = '.jpg,.jpeg,.png,.pdf,.xls,.xlsx,.doc,.docx,.ppt,.pptx,.txt')
    {
        $this->accept = $accept;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.file-upload');
    }
}
