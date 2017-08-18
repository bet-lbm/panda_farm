<?php

use Illuminate\Database\Seeder;
use Panda\Medicine;

class MedicinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Medicine::class,20)->create();
    }
}
