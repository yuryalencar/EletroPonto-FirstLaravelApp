<?php

use Illuminate\Database\Seeder;
use App\Models\Record;

class RecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Record::create([
            'user_id'        => '1',
            'business_hours'       => '10:10:20',
            'type'    => 'II',
        ]);

    }
}
