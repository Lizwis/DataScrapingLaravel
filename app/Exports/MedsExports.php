<?php

namespace App\Exports;

use App\Company;
use Maatwebsite\Excel\Concerns\FromCollection;

class MedsExports implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Company::select('name', 'telephone', 'location', 'catergory_id')->get();
    }
}