<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DealersTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(LaboratoriesTableSeeder::class);
        $this->call(PresentationsTableSeeder::class);
        $this->call(MedicinesTableSeeder::class);
        //$this->call(PurchasesTableSeeder::class);
        //$this->call(PurchaseDetailsTableSeeder::class);
    }
}
