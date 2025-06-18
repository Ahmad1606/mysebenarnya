<?php

namespace App\Exports;

use App\Models\McmcUser;
use Maatwebsite\Excel\Concerns\FromCollection;

class McmcUsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return McmcUser::all();
    }
}
