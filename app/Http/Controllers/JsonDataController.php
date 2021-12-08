<?php

namespace App\Http\Controllers;

use DB;
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


      // dd($data);
      foreach ($data as $event) {
        //event name
        $name = $event->name;

        //event location slowly moves down the object in order to eventually get the required level
        $venues = $event->schedules;
        $locations = json_encode($venues);
        $zone = json_decode($locations);

        //loop to get the postcode in case of multiple events
        foreach ($zone as $place) {
          $postcode = $place->place->postal_code;
        };

        //event_start_date
        $venues = $event->schedules;

        foreach ($venues as $place) {
          $start_date = $place->start_ts;
          $clean_start_date = preg_replace('/[^A-Za-z0-9]/', '', $start_date);
          $cleaner_start_date = filter_var($clean_start_date, FILTER_SANITIZE_NUMBER_INT);
          $only_start_date = substr($cleaner_start_date, 0, -10);

        };

        //event_end_date
        $venues = $event->schedules;

        foreach ($venues as $place) {
          $end_date = $place->end_ts;
          $clean_end_date = preg_replace('/[^A-Za-z0-9]/', '', $end_date);
          $cleaner_end_date = filter_var($clean_end_date, FILTER_SANITIZE_NUMBER_INT);
          $only_end_date = substr($cleaner_end_date, 0, -10);

        };
        //event_price
        //

        //event_performances - needs a table relationship or something

        //imagesx - needs another table relation

        //event_categories

        //event_contacts

        //event tickets?

        $entry = array( "event_name" => $name,
                        "event_location" => $postcode,
                        "event_start_date" => $only_start_date,
                        "event_end_date" => $only_end_date,
                        "event_price_min" => 7.3,
                        "event_price_max" => 7.3,
                        "event_performances" => $name,
                        "image_url" => $name,
                        "event_categories" => $name,
                        "event_contact_info" => $name,
                        "event_tickets_url" => $name,
                      );

        DB::table('events')->insert($entry);
        dd("if you've made it this far, it might well be working"); //used to stop inserting 600+ records
      }
    }
}
