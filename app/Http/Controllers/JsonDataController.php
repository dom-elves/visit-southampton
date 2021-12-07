<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonDataController extends Controller
{
    public function fetch(Request $request)
    {
      //sets the url variable of the api endpoint
      $url = "https://destinationcore-sample-files.s3.eu-west-2.amazonaws.com/visitsouthampton-thelist-feed.json";
      //makes data into a string
      $response = file_get_contents($url);
      //decodes into json
      $data = json_decode($response);
      //testing
      // dd($data);

      // foreach ($data as $event) {
      //   $name = $event->name;
      //   $location = $event->schedules;
      //
      // }
      // dd($location);


    }
}
