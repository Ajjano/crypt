<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /**
         *          $table->boolean('direction');
        $table->integer('address_in_id')->nullable();
        $table->string('address_out', 60)->nullable();
        $table->integer('type_id');
        $table->double('rate')->default(0);
         */
        // 0 - out, 1 - in
        $dir = rand(0,1);
        if ($dir==0){
            $address_in_id = null;
            $address_out = $this->faker->regexify('[a-z0-4]{60}');
        }else{
            $address_in_id = DB::table('addresses')
                ->inRandomOrder()
                ->first()->id;
            $address_out = null;
        }
        return [
            'direction'=>$dir,
            'address_in_id'=>$address_in_id,
            'address_out'=>$address_out,
            'type_id'=>$this->faker->numberBetween(1,4),
            'rate'=>(double)$this->faker->numberBetween(1,100)/100,
        ];
    }
}
