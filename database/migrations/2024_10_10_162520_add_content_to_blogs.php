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
        Schema::table('blogs', function (Blueprint $table) {
            $table->longText('content_ar_1')->nullable();
            $table->longText('content_en_1')->nullable();
            $table->longText('content_ar_2')->nullable();
            $table->longText('content_en_2')->nullable();
            $table->string('sub_title_ar')->nullable();
            $table->string('sub_title_en')->nullable();
            $table->json('blog_images')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            //
        });
    }
};
