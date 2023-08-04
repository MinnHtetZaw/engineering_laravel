<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RequestMaterial>
 */
class RequestMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'employee_id'=> rand(1,3),
            // 'project_id'=>  2,
            // 'project_phase_id'=> rand(1,3),
            // 'request_date'=>$this->faker->dateTimeBetween('+1 day','+2 weeks'),
            // 'reason'=>$this->faker->sentences(2),
            // 'requested_by'=>$this->faker->word(3),
        ];
    }
}
