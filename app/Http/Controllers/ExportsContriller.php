<?php

namespace App\Http\Controllers;

use App\Company;
use App\Exports\MedsExports;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class ExportsContriller extends Controller
{
    public function index()
    {
        return Excel::download(new MedsExports(), 'medsLeads.xlsx');
    }
}