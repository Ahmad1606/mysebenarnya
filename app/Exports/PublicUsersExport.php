<?php

namespace App\Exports;

use App\Models\PublicUser;
use Maatwebsite\Excel\Concerns\FromCollection;

class PublicUsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PublicUser::all();
    }
}
