<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventBannersTable extends Migration
{
    public function up()
    {
        Schema::create('event_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('path');
            $table->string('link')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_banners');
    }
}