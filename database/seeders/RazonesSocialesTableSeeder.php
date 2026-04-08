<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RazonesSocialesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('razones_sociales')->delete();
        
        \DB::table('razones_sociales')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'TECH ENERGY CONTROL S.A. DE C.V.',
                'short_name' => 'Tech Energy Control',
                'logo' => 'https://res.cloudinary.com/gpt-services/image/upload/v1635975373/logo_GPT_yhm2ut.svg',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'GPT INGENIERIA Y MANUFACTURA S.A. DE C.V.',
                'short_name' => 'GPT Ingeniería y Manufactura',
                'logo' => 'https://res.cloudinary.com/gpt-services/image/upload/v1641229888/GPT-Manufactura-logo_qoqmfq.png',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'ESQUEMA',
                'short_name' => 'ESQUEMA',
                'logo' => 'https://res.cloudinary.com/gpt-services/image/upload/v1635975373/logo_GPT_yhm2ut.svg',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'NO APLICA',
                'short_name' => 'NO APLICA',
                'logo' => 'https://res.cloudinary.com/gpt-services/image/upload/v1635975373/logo_GPT_yhm2ut.svg',
            ),
        ));
        
        
    }
}