<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->callOnce(RoleSeeder::class);
        $this->callOnce(UserSeeder::class);

        //        $travels = Travel::factory(25)->create();
        //
        //        foreach ( $travels as $travel ) {
        //
        //            if( !$travel->is_public ) {
        //                continue;
        //            }
        //
        //            Tour::factory( rand( 1,10 ) )->create(['travel_id' => $travel->id]);
        //        }

    }
}
