<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            $table->integer('artist_id')->unsigned();
            $table->string('title');
            $table->string('slug')->unique();
            $table->tinyInteger('isLive')->default(0);
            $table->string('provider_id', 255);
            $table->enum('provider', ['youtube', 'vimeo']);
            $table->string('tags')->nullable();
            $table->integer('clicks')->unsigned()->default(0);
            $table->text('description')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('cancel_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stream');
    }
}
