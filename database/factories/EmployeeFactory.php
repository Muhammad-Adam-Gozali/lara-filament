<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => $this->faker->optional()->firstName(),
            'department_id' => \App\Models\Department::inRandomOrder()->first()->id,
            'country_id' => \App\Models\Country::inRandomOrder()->first()->id,
            'state_id' => \App\Models\State::inRandomOrder()->first()->id,
            'city_id' => \App\Models\City::inRandomOrder()->first()->id,
            'address' => $this->faker->address(),
            'date_hired' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'date_of_birth' => $this->faker->dateTimeBetween('-50 years', '-18 years'),
        ];
    }
}
