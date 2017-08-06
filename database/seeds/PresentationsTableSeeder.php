<?php

use App\Presentation;
use Illuminate\Database\Seeder;

class PresentationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Presentation::class,50)->create();
    }
}
