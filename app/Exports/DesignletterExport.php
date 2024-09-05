<?php

namespace App\Exports;

use App\Models\Designletter;
use Maatwebsite\Excel\Concerns\FromCollection;

class DesignletterExport implements FromCollection
{
    protected $month;
    protected $year;

    public function __construct($month = null, $year = null)
    {
        $this->month = $month;
        $this->year = $year;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Designletter::query();

        if ($this->month) {
            $query->whereMonth('created_at', $this->month);
        }

        if ($this->year) {
            $query->whereYear('created_at', $this->year);
        }

        return $query->get();
    }
}
