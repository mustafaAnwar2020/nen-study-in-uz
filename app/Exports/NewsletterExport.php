<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class NewsletterExport implements FromView, WithEvents
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function view(): View
    {
        return view('admin.xls.newsletter', [
            'rows' => $this->data,
        ]);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }


}
