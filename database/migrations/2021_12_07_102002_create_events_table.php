<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() //migration for table of consolidated data
    {
        Schema::create('events', function (Blueprint $table) {
          $table->id();
          $table->string('event_name');
          $table->string('event_location');
          $table->integer('event_start_date');
          $table->integer('event_end_date');
          $table->decimal('event_price_min', 9,2 )->nullable();
          $table->decimal('event_price_max', 9,2 )->nullable();
          $table->string('event_performances')->nullable();
          $table->string('image_url')->nullable();
          $table->string('event_categories')->nullable();
          $table->string('event_contact_info');
          $table->string('event_tickets_url');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
