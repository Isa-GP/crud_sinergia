<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
        'tipo_documento_id' => 1,
        'numero_documento' => $this->faker->unique()->numerify('##########'),
        'nombre1' => $this->faker->firstName,
        'nombre2' => $this->faker->firstName,
        'apellido1' => $this->faker->lastName,
        'apellido2' => $this->faker->lastName,
        'genero_id' => 1,
        'departamento_id' => 1,
        'municipio_id' => 1,
        'correo' => $this->faker->email,
    ];
    }
}
