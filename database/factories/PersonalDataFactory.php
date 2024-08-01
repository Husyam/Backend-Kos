<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalData>
 */
class PersonalDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // $table->id();
            // $table->string('name');

            // $table->string('gender');

            // $table->string('profession');
            // $table->string('contact');

            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // $table->boolean('is_default')->default(false);
            // $table->timestamps();

            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'profession' => $this->faker->jobTitle(),
            'contact' => $this->faker->regexify('\+62 8[1-9][0-9]{2}-[0-9]{4}-[0-9]{4}'),
            'user_id' => $this->faker->numberBetween(1, 10),
            'is_default' => $this->faker->boolean(),

        ];
    }
}
