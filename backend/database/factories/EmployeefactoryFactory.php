<?php

namespace Database\Factories;

use App\Models\EmployeeModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    // The name of the corresponding model
    protected $model = EmployeeModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'age' => $this->faker->numberBetween(18, 65),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
            'position' => $this->faker->jobTitle,
            'contact_number' => $this->faker->phoneNumber,
        ];
    }
}
