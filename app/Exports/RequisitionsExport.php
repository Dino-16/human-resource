<?php

namespace App\Exports;

use App\Models\Recruitment\Requisition;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class RequisitionsExport implements FromQuery
{
    use Exportable;

    public function query() 
    {
        return Requisition::query();
    }

}