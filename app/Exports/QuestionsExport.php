<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuestionsExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $data;
 
    public function __construct(array $data)
    {
        $this->data = $data;
    }


    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'subject_id',
            'subject',
            'question',
            'option_a',
            'option_b',
            'option_c',
            'option_d',
            'answer',
        ];
    }
}
