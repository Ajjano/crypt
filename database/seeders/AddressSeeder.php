<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //seeding
        for ($i=0;$i<150000;$i++){
            Address::factory()->voucher()->create();
        }
        for ($i=0;$i<40000;$i++){
            Address::factory()->invoice()->create();
        }
        for ($i=0;$i<120000;$i++){
            Address::factory()->account()->create();
        }

        for ($i=0;$i<25000;$i++){
            Address::factory()->common()->create();
        }



        $this->call([
            TransactionSeeder::class
        ]);
    }
}
