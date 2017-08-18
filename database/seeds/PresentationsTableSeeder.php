<?php


use Illuminate\Database\Seeder;
use Panda\Presentation;

class PresentationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Presentation::class,15)->create();
    }
}
