<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PendingTransitionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pending_transitions')->delete();
        
        
        
    }
}