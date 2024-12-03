<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Religion;


class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        Religion::insert([
            ['name' => 'Islam', 'description' => 'A monotheistic religion articulated by the Quran, a text considered by its adherents to be the verbatim word of God.'],
            ['name' => 'Christianity', 'description' => 'A major religion based on the life and teachings of Jesus Christ.'],
            ['name' => 'Hinduism', 'description' => 'A religion and way of life, widely practiced in South Asia.'],
            ['name' => 'Buddhism', 'description' => 'A nontheistic religion that encompasses a variety of traditions, beliefs, and practices.'],
        ]);
    }
}
