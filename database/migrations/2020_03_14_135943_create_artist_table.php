<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('realName');
            $table->string('email');
            $table->string('avatar')->nullable();
            $table->string('twitter')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('vat')->nullable();
            $table->string('iban', 34)->nullable();
            $table->string('activityProof')->nullable();
            $table->tinyInteger('isVerified')->default(0);
            $table->tinyInteger('wantDonation')->default(0);
            $table->string('iban')->nullable();
            $table->string('facebook')->nullable();
            $table->string('facebookId')->nullable();
            $table->tinyInteger('isRegistrationComplete')->default(0);
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
        Schema::dropIfExists('artists');
    }
}
