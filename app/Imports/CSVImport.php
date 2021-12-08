<?php

namespace App\Imports;

use App\Models\Events;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CSVImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

      //inserts data from the user uploaded spreadsheet
      return new Events([

          'event_name'           => $row['name'],
          'event_location'       => $row['event_location'],
          'event_start_date'     => $row['start_date'],
          'event_end_date'       => $row['end_date'],
          //price not available in csv data
          //performances not available in csv data
          'event_photo'          => $row['event_photo'],
          //categories not available in csv data
          'event_tickets_url'    => $row['event_web_link'],
          'event_contact_info'   => $row['event_telephone'],

      ]);
    }
}
