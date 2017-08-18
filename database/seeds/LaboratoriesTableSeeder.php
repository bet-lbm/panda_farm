<?php

use Illuminate\Database\Seeder;
use Panda\Laboratory;

class LaboratoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         factory(Laboratory::class,50)->create();
    }
}
