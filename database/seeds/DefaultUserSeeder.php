<?php

use Illuminate\Database\Seeder;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $artist = new \App\Models\Artist();
        $artist->email = "geral@geral.com";
        $artist->password = \Hash::make("12345678");
        $artist->name = "Geral";
        $artist->isRegistrationComplete = 1;
        $artist->realName = "My Real Name";
        $artist->save();
    }
}
