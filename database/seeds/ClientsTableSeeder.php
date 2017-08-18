<?php

use Illuminate\Database\Seeder;
use Panda\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Client::class,50)->create();
    }
}
