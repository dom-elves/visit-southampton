<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CSVImport;
use Maatwebsite\Excel\Facades\Excel;

class CSVDataController extends Controller
{
    public function upload(Request $request)
    {
      //sets file variable
      $file = $request->file();
      //sets extension variable
      $extension = $request->file->getClientOriginalExtension();
      //validation for .xlsx filetype
      if ($extension == 'xlsx') {
        //uploads if correct
        Excel::import( new CSVImport, request()->file('file') );
        return redirect('/csvdata');

      } else {
        //an actual alert is out of scope
        dd('incorrect file type, please go back');

      }

    }
}
