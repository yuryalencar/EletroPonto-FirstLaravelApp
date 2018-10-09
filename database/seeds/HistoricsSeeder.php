<?php

use Illuminate\Database\Seeder;
use App\Models\Historic;

class HistoricsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Historic::create([
            'user_id'        => '1',
            'business_hours'       => '2018-10-09 12:34:18',
            'record_id'    => '1',
        ]);

    }
}
