<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CSVEvent extends Model
{
    use HasFactory;

    protected $fillable = [

        'event_name',
        'event_location',
        'event_start_date',
        'event_end_date',
        'event_price',
        'event_performances',
        'image_url',
        'event_categories',
        'event_contact_info',
        'event_tickets_url',

    ];
}
