<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function getIndex()
    {
        $agenda = DB::table('agenda')->count();

        return view('pages.index', compact('agenda'));
    }
}
