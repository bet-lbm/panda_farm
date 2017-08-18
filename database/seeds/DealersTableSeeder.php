<?php

use Illuminate\Database\Seeder;
use Panda\Dealer;

class DealersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Dealer::class,50)->create();
    }
}
