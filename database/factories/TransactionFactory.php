<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    /**
   
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**

     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), 
            'name' => $this->faker->word, 
            'type' => $this->faker->randomElement(['revenu', 'dépense']), 
            'amount' => $this->faker->randomFloat(2, 1, 1000), 
            'date' => $this->faker->date, 
            'description' => $this->faker->sentence,
        ];
    }
}

