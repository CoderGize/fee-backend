<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable();
            $table->longText('about_en')->nullable();
            $table->longText('about_ar')->nullable();
            $table->longText('vision_en')->nullable();
            $table->longText('vision_ar')->nullable();
            $table->longText('mission_en')->nullable();
            $table->longText('mission_ar')->nullable();
            $table->longText('whyus_title_en')->nullable();
            $table->longText('whyus_title_ar')->nullable();
            $table->json('whyus_text_en')->nullable();
            $table->json('whyus_text_ar')->nullable();
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
        Schema::dropIfExists('abouts');
    }
};
