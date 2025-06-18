<?php

namespace App\Exports;

use App\Models\AgencyUser;
use Maatwebsite\Excel\Concerns\FromCollection;

class AgencyUsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AgencyUser::all();
    }
}
