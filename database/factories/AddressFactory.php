<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;
    static $collection;
    static function getCol(){
        static::$collection=Voucher::select('id')->get()->toArray();
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->numberBetween(1,4);

        return [
            'name' => $this->faker->regexify('[a-z0-4]{60}'),
            'type_id' => $type,

        ];
    }

    public function voucher()
    {
        return $this->state(function (array $attributes) {
            return [
                'addressable_id' => function () {
                    return Voucher::factory()->create()->id;
                },
                'addressable_type' => Voucher::class,
            ];
        });
    }

    public function common()
    {
        return $this->state(function (array $attributes) {

            /**
             * 1. генератор сущности
             * 2. достаем все айди
             * 3. рандомное айди
             * 4. рандомный тип
             * 5. если в таблице есть такое айди сущности, сущность и такой тип, генерим дальше
             */


            while(true){
                $types_item=[
                    Voucher::class,
                    Invoice::class,
                    Account::class
                ];
                $random_type = $this->faker->randomElement($types_item);
                $collection = $random_type::select('id')->get()->toArray();
                $item_id = rand(0, count($collection)-1);
                $type = $this->faker->numberBetween(1,4);
                $result = Address::where('type_id', $type)->where('addressable_id', (int)$collection[$item_id]['id'])
                    ->where('addressable_type', $random_type)->first();
                echo (int)$collection[$item_id]['id'];
                if((int)$collection[$item_id]['id']==0){
                    print_r($collection);
                }
                if(is_null($result)){
                    break;
                }
            }

            return [
                'type_id' => $type,
                'addressable_id' => (int)$collection[$item_id]['id'],
                'addressable_type' => $random_type,
            ];
        });
    }


    public function invoice()
    {
        return $this->state(function (array $attributes) {
            return [
                'addressable_id' => function () {
                    return Invoice::factory()->create()->id;
                },
                'addressable_type' => Invoice::class,
            ];
        });
    }

    public function account()
    {
        return $this->state(function (array $attributes) {
            return [
                'addressable_id' => function () {
                    return Account::factory()->create()->id;
                },
                'addressable_type' => Account::class,
            ];
        });
    }
}
