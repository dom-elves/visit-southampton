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


      foreach ($data as $event) {

        //event name
        $name = $event->name;

        //event location slowly moves down the object in order to eventually get the required level
        $venues = $event->schedules;
        // dd($venues);
        $locations = json_encode($venues);
        $zone = json_decode($locations);

        //loop to get the postcode in case of multiple events
        foreach ($zone as $place) {
          $postcode = $place->place->postal_code;
        };

        //event_start_date
        foreach ($venues as $place) {
          $start_date = $place->start_ts;
          $clean_start_date = preg_replace('/[^A-Za-z0-9]/', '', $start_date);
          $cleaner_start_date = filter_var($clean_start_date, FILTER_SANITIZE_NUMBER_INT);
          $only_start_date = substr($cleaner_start_date, 0, -10);

        };

        //event_end_date
        foreach ($venues as $place) {
          $end_date = $place->end_ts;
          $clean_end_date = preg_replace('/[^A-Za-z0-9]/', '', $end_date);
          $cleaner_end_date = filter_var($clean_end_date, FILTER_SANITIZE_NUMBER_INT);
          $only_end_date = substr($cleaner_end_date, 0, -10);

        };
        //event min price
        foreach ($venues as $place) {

          $performances = $place->performances;

          foreach ($performances as $shows) {

            $tickets = $shows->tickets;

            foreach ($tickets as $prices) {

              if (property_exists($prices, 'min_price')) { //checks if min price is an object attribute

              $min_price = $prices->min_price;

              } else {

                $min_price = 0;

              }

              $check = strlen((string)$min_price);

              if ($check > 5) {

                echo("this is far too expensive for a ticket to a show, please check the data source");

              } else {

                  continue;

                }
            }
          }
        }
        //event max price
        foreach ($venues as $place) {

          $performances = $place->performances;

          foreach ($performances as $shows) {

            $tickets = $shows->tickets;

            foreach ($tickets as $prices) {

              if (property_exists($prices, 'max_price')) { //checks if min price is an object attribute

              $max_price = $prices->max_price;

              } else {

                $max_price = 0;

              }

              $check = strlen((string)$max_price);

              if ($check > 5) {

                echo("this is far too expensive for a ticket to a show, please check the data source");

              } else {

                  continue;

                }
            }
          }
        }

        //event_performances - needs a table relationship or something
        foreach ($venues as $place) {

          $performances = $place->performances;
          $gig = json_encode($performances);
          //$gig currently returns as a string - couldn't figure out how to get it into a blob so it could be stored;

        }
        //images
        if (property_exists($event, 'images')) {
        $image_list = $event->images;

        foreach ($image_list as $image) {
          $image_url = $image->url;

        }
      } else {
        continue;
      }
        //event_categories
        $category = $event->category;

        //event_contacts
        foreach ($venues as $place) {

          $performances = $place->place;
          if (property_exists($performances, 'phone_numbers')) {
          $number = $performances->phone_numbers;
            if (property_exists($number, 'info')) {
              $phone_number = $number->info;
            }
        } else {
          continue;
        }
      }

        //event tickets
        foreach ($venues as $place) {

          $performances = $place->performances;

          foreach ($performances as $ticket_list);

          if (property_exists($ticket_list, 'links')) {

            $url_list = $ticket_list->links;

            foreach ($url_list as $booking) {

              $ticket_link = $booking->url;

            }
          } else {

            echo 'no ticket link found';

          }
        }

        $entry = array( "event_name" => $name,
                        "event_location" => $postcode,
                        "event_start_date" => $only_start_date, //would have converted to correct dates
                        "event_end_date" => $only_end_date, //would have converted to correct dates
                        "event_price_min" => $min_price, //echo message if over 5 digits, would have been error message
                        "event_price_max" => $max_price, //echo message if over 5 digits, would have been error message
                        "event_performances" => 'refer to notes', //$gig currently returns as a string - couldn't figure out how to get it into a blob so it could be stored;
                        "image_url" => $image_url, //had to add an "if exists" check to this though they all seem to have one?
                        "event_categories" => $category,
                        "event_contact_info" => $phone_number, //accessing this seemed to be inconsistently structured, hence the various property checks
                        "event_tickets_url" => $ticket_link, //the echo returned 25 results so maybe 25 events without links, or they're somewhere else
                      );

        DB::table('events')->insert($entry);
        // dd("if you've made it this far, it might well be working"); //used to stop inserting 600+ records
      }
    }
}
