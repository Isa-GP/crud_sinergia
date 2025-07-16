<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Paciente;

class PacienteTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

    // Crear usuario para login
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('1234567890'), // Usa bcrypt o Hash::make
    ]);

    // Intentar login
    $response = $this->postJson('/api/login', [
        'email' => 'admin@example.com',
        'password' => '1234567890',
    ]);

    if (!isset($response['token'])) {
        dump($response->json());
        $this->fail('No se pudo obtener el token. Verifica tu lógica de login.');
    }

    $this->token = $response['token'];
    }

    /** @test */
    public function puede_crear_un_paciente()
    {
        $data = [
            'tipo_documento_id' => 1,
            'numero_documento' => '1234567890',
            'nombre1' => 'Laura',
            'nombre2' => 'María',
            'apellido1' => 'Gómez',
            'apellido2' => 'Rojas',
            'genero_id' => 1,
            'departamento_id' => 1,
            'municipio_id' => 1,
            'correo' => 'laura@example.com'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                         ->postJson('/api/pacientes', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('pacientes', ['numero_documento' => '1234567890']);
    }

    /** @test */
    public function puede_listar_pacientes()
    {
        // Crear 3 pacientes con factory o manual
        Paciente::create([
            'tipo_documento_id' => 1,
            'numero_documento' => '1111111111',
            'nombre1' => 'Test',
            'apellido1' => 'Paciente',
            'genero_id' => 1,
            'departamento_id' => 1,
            'municipio_id' => 1,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                         ->getJson('/api/pacientes');

        $response->assertStatus(200);
        $response->assertJsonStructure([['id', 'nombre1', 'apellido1']]);
    }
}
