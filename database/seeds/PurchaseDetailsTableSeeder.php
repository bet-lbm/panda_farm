<?php

use Illuminate\Database\Seeder;
use Panda\PurchaseDetail;

class PurchaseDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PurchaseDetail::class,15)->create();
    }
}
