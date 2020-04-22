<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempURLSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signed_url', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('files_id');
            $table->string('temp_url');
            $table->string('hash_key')->unique();
            $table->dateTime('expiry_time');
            $table->boolean('isEnable')->nullable()->default(true);
            $table->timestamps();
        });
        Schema::table('signed_url', function ($table) {
            $table->foreign('files_id')->references('id')->on('shared_files')->onDelete('set null');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signed_url');
    }
}
