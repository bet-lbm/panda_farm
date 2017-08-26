<?php

use Illuminate\Database\Seeder;
use Panda\Purchase;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Purchase::class,5)->create();
    }
}
